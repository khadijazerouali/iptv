<?php

namespace App\Http\Controllers\Public;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'type' => 'nullable|string|max:255',
            'message' => 'required|string',
            'ip' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);

        $contact = Contact::create($request->all());

        return redirect()->route('home')
            ->with('success','Votre message a été envoyé avec succès.');
    }
}
