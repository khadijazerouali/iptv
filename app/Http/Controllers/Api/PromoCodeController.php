<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PromoCodeService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PromoCodeController extends Controller
{
    protected $promoCodeService;

    public function __construct(PromoCodeService $promoCodeService)
    {
        $this->promoCodeService = $promoCodeService;
    }

    /**
     * Valider un code promo
     */
    public function validate(Request $request): JsonResponse
    {
        $request->validate([
            'code' => 'required|string|max:50',
            'subtotal' => 'nullable|numeric|min:0'
        ]);

        $code = $request->input('code');
        $subtotal = $request->input('subtotal', 0);

        $result = $this->promoCodeService->validateCode($code, $subtotal);

        return response()->json($result);
    }

    /**
     * Appliquer un code promo
     */
    public function apply(Request $request): JsonResponse
    {
        $request->validate([
            'code' => 'required|string|max:50',
            'subtotal' => 'nullable|numeric|min:0'
        ]);

        $code = $request->input('code');
        $subtotal = $request->input('subtotal', 0);

        $result = $this->promoCodeService->applyCode($code, $subtotal);

        return response()->json($result);
    }

    /**
     * Supprimer un code promo appliqué
     */
    public function remove(): JsonResponse
    {
        $result = $this->promoCodeService->removeCode();

        return response()->json($result);
    }

    /**
     * Obtenir le code promo appliqué
     */
    public function getApplied(): JsonResponse
    {
        $appliedCode = $this->promoCodeService->getAppliedCode();

        return response()->json([
            'applied_code' => $appliedCode
        ]);
    }

    /**
     * Calculer le total avec réduction
     */
    public function calculateTotal(Request $request): JsonResponse
    {
        $request->validate([
            'subtotal' => 'required|numeric|min:0'
        ]);

        $subtotal = $request->input('subtotal');
        $result = $this->promoCodeService->calculateTotalWithDiscount($subtotal);

        return response()->json($result);
    }
} 