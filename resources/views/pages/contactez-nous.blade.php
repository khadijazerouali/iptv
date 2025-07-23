@extends('layouts.main')


@section('title', 'Page contactez-nous')

@section('styles')
<link href="{{ asset('/assets/css/style_contact.css') }}" rel="stylesheet">
@endsection  

@section('content')
 <!-- main content -->
 <div class="container-fluid contact-header text-center py-5 align-items-center d-flex justify-content-center">
    <h1>Contacter-nous</h1>
</div>

<div class="contact-section">
    <div class="contact-container">
        <div class="contact-info">
            <h2>Nous contacter <span class="highlight">.</span></h2>
            <p>
                Appelez-nous, envoyez-nous un e-mail ou remplissez le formulaire de contact et nous vous répondrons.
            </p>
            <div class="contact-details">
                <div class="contact-item">
                    <i class="icon fa fa-paper-plane"></i>
                    <span>
                        Notre mail de contact : <br />
                        <strong>Commande@abonnement-iptvpremium.com</strong>
                    </span>
                </div>
                <div class="contact-item">
                    <i class="icon fa fa-phone"></i>
                    <span>
                        Notre Numéro whatsapp : <br />
                        <strong>+34 673 52 18 12</strong>
                    </span>
                </div>
            </div>
        </div>
   
        <div class="contact-form" id="contact-form">
   


    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('contact.store') }}" method="POST">
    @csrf
    <label for="name">Nom <span class="required">*</span></label>
    <input type="text" id="name" name="name" class="form-input" required />

    <label for="email">E-mail <span class="required">*</span></label>
    <input type="email" id="email" name="email" class="form-input" required />

    <label for="type">Type de demande <span class="required">*</span></label>
    <select id="type" name="type" class="form-input" required>
        <option value="Commercial">Commercial</option>
        <option value="Support">Support</option>
        <option value="Autre">Autre</option>
    </select>

    <label for="message">Votre message <span class="required">*</span></label>
    <textarea id="message" name="message" class="form-input" rows="5" required></textarea>

    <button type="submit" class="submit-btn">Envoyer</button>
</form>

</div>



    </div>
</div>
    <div class="class mb-1"></div>
    @endsection 