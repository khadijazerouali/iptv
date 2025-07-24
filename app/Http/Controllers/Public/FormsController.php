<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FormsController extends Controller
{
    public function forms(Request $request)
    {
        
        $product_uuid = $request->input('product_uuid');
        if (!$product_uuid) {
            return redirect()->back()->with('error', 'not found.');
        }
        // dd($request->all());
        $validatedData = $request->validate([
            'product_uuid' => 'required',
            'quantity' => 'required|integer|min:1|max:99',
            'selectedOptionUuid' => 'required',
            'selectedDeviceType' => 'required',
            'selectedApplicationType' => 'required',
            'channels' => 'required',
            'vods' => 'required',
            'macaddress' => 'nullable',
            'magaddress' => 'nullable',
            'formulermac' => 'nullable',
            'deviceid' => 'nullable',
            'devicekey' => 'nullable',
            'otpcode' => 'nullable',
            'smartstbmac' => 'nullable',
        ]);

        // Save the validated data into the session
        $request->session()->put('abonnement_data', $validatedData);

        // Flash a success message
        session()->flash('message', 'Commande envoyée avec succès.');

        // Optionally, redirect to another page
        return redirect()->route('subscriptions.success');
    }


}
