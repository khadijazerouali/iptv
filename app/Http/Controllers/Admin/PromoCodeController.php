<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use App\Models\User;
use App\Models\Product;
use App\Models\CategoryProduct;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PromoCodeController extends Controller
{
    public function index()
    {
        $promoCodes = PromoCode::orderBy('created_at', 'desc')->paginate(15);
        
        $stats = [
            'total' => PromoCode::count(),
            'active' => PromoCode::where('is_active', true)->count(),
            'expired' => PromoCode::where('valid_until', '<', now())->count(),
            'total_usage' => PromoCode::sum('used_count'),
            'total_emails_sent' => PromoCode::sum('email_sent_count')
        ];

        return view('admin.promo-codes.index', compact('promoCodes', 'stats'));
    }

    public function create()
    {
        $products = Product::all();
        $categories = CategoryProduct::all();
        
        return view('admin.promo-codes.create', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_amount' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'required|integer|min:1',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after:valid_from',
            'is_active' => 'boolean',
            'applies_to' => 'required|in:all,specific_products,specific_categories',
            'applies_to_ids' => 'nullable|array',
            'code' => 'nullable|string|unique:promo_codes,code'
        ]);

        // Générer un code unique si non fourni
        if (empty($validated['code'])) {
            $validated['code'] = PromoCode::generateUniqueCode();
        } else {
            $validated['code'] = strtoupper($validated['code']);
        }

        // Gérer les dates
        $validated['valid_from'] = $validated['valid_from'] ? Carbon::parse($validated['valid_from']) : null;
        $validated['valid_until'] = $validated['valid_until'] ? Carbon::parse($validated['valid_until']) : null;

        $promoCode = PromoCode::create($validated);

        return redirect()->route('admin.promo-codes.index')
            ->with('success', 'Code promo créé avec succès !');
    }

    public function show(PromoCode $promoCode)
    {
        return view('admin.promo-codes.show', compact('promoCode'));
    }

    public function edit(PromoCode $promoCode)
    {
        $products = Product::all();
        $categories = CategoryProduct::all();
        
        return view('admin.promo-codes.edit', compact('promoCode', 'products', 'categories'));
    }

    public function update(Request $request, PromoCode $promoCode)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_amount' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'required|integer|min:1',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after:valid_from',
            'is_active' => 'boolean',
            'applies_to' => 'required|in:all,specific_products,specific_categories',
            'applies_to_ids' => 'nullable|array',
            'code' => 'nullable|string|unique:promo_codes,code,' . $promoCode->id
        ]);

        // Gérer les dates
        $validated['valid_from'] = $validated['valid_from'] ? Carbon::parse($validated['valid_from']) : null;
        $validated['valid_until'] = $validated['valid_until'] ? Carbon::parse($validated['valid_until']) : null;

        $promoCode->update($validated);

        return redirect()->route('admin.promo-codes.index')
            ->with('success', 'Code promo mis à jour avec succès !');
    }

    public function destroy(PromoCode $promoCode)
    {
        $promoCode->delete();

        return redirect()->route('admin.promo-codes.index')
            ->with('success', 'Code promo supprimé avec succès !');
    }

    public function sendToUsers(Request $request, PromoCode $promoCode)
    {
        $validated = $request->validate([
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id'
        ]);

        $users = User::whereIn('id', $validated['user_ids'])->get();
        $sentCount = 0;
        $errors = [];

        foreach ($users as $user) {
            try {
                EmailService::sendNotificationEmail(
                    $user,
                    '🎫 Code promo spécial IPTV - ' . $promoCode->name,
                    'emails.promo-code',
                    ['promoCode' => $promoCode]
                );
                $sentCount++;
            } catch (\Exception $e) {
                $errors[] = "Erreur pour {$user->email}: " . $e->getMessage();
                Log::error('Erreur envoi email promo code à ' . $user->email . ': ' . $e->getMessage());
            }
        }

        // Mettre à jour les statistiques du code promo
        $promoCode->incrementEmailSent();

        // Envoyer une notification à l'admin
        try {
            $adminUser = User::where('email', 'admin@admin.com')->first();
            if ($adminUser) {
                EmailService::sendNotificationEmail(
                    $adminUser,
                    '📧 Rapport d\'envoi de code promo - ' . $promoCode->name,
                    'emails.admin-promo-report',
                    [
                        'promoCode' => $promoCode,
                        'sentCount' => $sentCount,
                        'totalUsers' => count($users),
                        'errors' => $errors,
                        'admin' => auth()->guard('web')->user()
                    ]
                );
            }
        } catch (\Exception $e) {
            Log::error('Erreur envoi rapport admin: ' . $e->getMessage());
        }

        $message = "Code promo envoyé à {$sentCount} utilisateur(s) avec succès !";
        if (!empty($errors)) {
            $message .= " Erreurs: " . count($errors) . " email(s) non envoyé(s).";
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'sent_count' => $sentCount,
            'errors' => $errors
        ]);
    }

    public function sendToAllUsers(Request $request, PromoCode $promoCode)
    {
        // Récupérer tous les utilisateurs actifs (excluant l'admin)
        $users = User::where('email', '!=', 'admin@admin.com')
                    ->where('email', '!=', '')
                    ->whereNotNull('email')
                    ->get();

        if ($users->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun utilisateur actif trouvé pour l\'envoi d\'emails.'
            ]);
        }

        $sentCount = 0;
        $errors = [];

        foreach ($users as $user) {
            try {
                EmailService::sendNotificationEmail(
                    $user,
                    '🎫 Code promo spécial IPTV - ' . $promoCode->name,
                    'emails.promo-code',
                    ['promoCode' => $promoCode]
                );
                $sentCount++;
            } catch (\Exception $e) {
                $errors[] = "Erreur pour {$user->email}: " . $e->getMessage();
                Log::error('Erreur envoi email promo code à ' . $user->email . ': ' . $e->getMessage());
            }
        }

        // Mettre à jour les statistiques du code promo
        $promoCode->incrementEmailSent();

        // Envoyer une notification à l'admin
        try {
            $adminUser = User::where('email', 'admin@admin.com')->first();
            if ($adminUser) {
                EmailService::sendNotificationEmail(
                    $adminUser,
                    '📧 Rapport d\'envoi de code promo - ' . $promoCode->name,
                    'emails.admin-promo-report',
                    [
                        'promoCode' => $promoCode,
                        'sentCount' => $sentCount,
                        'totalUsers' => count($users),
                        'errors' => $errors,
                        'admin' => auth()->guard('web')->user()
                    ]
                );
            }
        } catch (\Exception $e) {
            Log::error('Erreur envoi rapport admin: ' . $e->getMessage());
        }

        $message = "Code promo envoyé à {$sentCount} utilisateur(s) sur " . count($users) . " avec succès !";
        if (!empty($errors)) {
            $message .= " Erreurs: " . count($errors) . " email(s) non envoyé(s).";
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'sent_count' => $sentCount,
            'total_users' => count($users),
            'errors' => $errors
        ]);
    }

    public function getUsersForPromo()
    {
        $users = User::select('id', 'name', 'email')
            ->where('email', '!=', 'admin@admin.com')
            ->orderBy('name')
            ->get();

        return response()->json($users);
    }

    public function toggleStatus(PromoCode $promoCode)
    {
        $promoCode->update(['is_active' => !$promoCode->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $promoCode->is_active,
            'message' => $promoCode->is_active ? 'Code promo activé !' : 'Code promo désactivé !'
        ]);
    }

    public function duplicate(PromoCode $promoCode)
    {
        $newPromoCode = $promoCode->replicate();
        $newPromoCode->code = PromoCode::generateUniqueCode();
        $newPromoCode->name = $promoCode->name . ' (Copie)';
        $newPromoCode->used_count = 0;
        $newPromoCode->email_sent_count = 0;
        $newPromoCode->last_sent_at = null;
        $newPromoCode->save();

        return redirect()->route('admin.promo-codes.index')
            ->with('success', 'Code promo dupliqué avec succès !');
    }
} 