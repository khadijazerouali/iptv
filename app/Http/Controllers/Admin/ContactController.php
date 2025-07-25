<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ContactController extends Controller
{
    public function index()
    {
        // Statistiques des contacts
        $stats = [
            'total_contacts' => Contact::count(),
            'pending_contacts' => Contact::where('status', 'pending')->count(),
            'read_contacts' => Contact::where('status', 'read')->count(),
            'replied_contacts' => Contact::where('status', 'replied')->count(),
            'closed_contacts' => Contact::where('status', 'closed')->count(),
        ];

        // Contacts avec pagination
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.contacts', compact('stats', 'contacts'));
    }

    public function show($uuid)
    {
        $contact = Contact::where('uuid', $uuid)->firstOrFail();
        
        // Marquer comme lu si le statut est pending
        if ($contact->status === 'pending') {
            $contact->update(['status' => 'read']);
        }

        return response()->json($contact);
    }

    public function update(Request $request, $uuid)
    {
        $contact = Contact::where('uuid', $uuid)->firstOrFail();
        
        $validated = $request->validate([
            'status' => 'required|in:pending,read,replied,closed',
        ]);

        $contact->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Statut du contact mis à jour avec succès'
        ]);
    }

    public function destroy($uuid)
    {
        $contact = Contact::where('uuid', $uuid)->firstOrFail();
        $contact->delete();

        return response()->json([
            'success' => true,
            'message' => 'Contact supprimé avec succès'
        ]);
    }

    public function markAsReplied($uuid)
    {
        $contact = Contact::where('uuid', $uuid)->firstOrFail();
        $contact->update(['status' => 'replied']);

        return response()->json([
            'success' => true,
            'message' => 'Contact marqué comme répondu'
        ]);
    }

    public function markAsClosed($uuid)
    {
        $contact = Contact::where('uuid', $uuid)->firstOrFail();
        $contact->update(['status' => 'closed']);

        return response()->json([
            'success' => true,
            'message' => 'Contact marqué comme fermé'
        ]);
    }
}
