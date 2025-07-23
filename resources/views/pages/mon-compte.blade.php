@extends('layouts.main')

@section('title', 'Page compte')
@section('styles')
<link href="{{ asset('/assets/css/style_compte.css') }}" rel="stylesheet">
@endsection  
@section('content')

    <div class="container form-container" style="margin-bottom: 300px;">
        <div class="row justify-content-center">
            <!-- Login Form -->
            <div class="col-md-6">
                <h2 class="page-title">Se connecter</h2>
                <div class="card p-4 mt-3">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="login-email" class="form-label">Identifiant ou e-mail *</label>
                            <input type="email" class="form-control" id="login-email" name="email" placeholder="Enter votre e-mail">
                        </div>
                        <div class="mb-3">
                            <label for="login-password" class="form-label">Mot de passe *</label>
                            <input type="password" class="form-control" id="login-password" name="password" placeholder="Mot de passe">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember-me">
                            <label class="form-check-label" for="remember-me">Se souvenir de moi</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Se Connecter</button>
                        <a href="{{ route('password.request') }}" class="d-block mt-3">Mot de passe perdu ?</a>
                    </form>
                </div>
            </div>
    
            <!-- Register Form -->
            <div class="col-md-6 mb-4">
                <h2 class="page-title">S'enregistrer</h2>
                <div class="card p-4 mt-3">
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="register-name" class="form-label">Nom et prénom *</label>
                            <input type="text" class="form-control" id="register-name" name="name" placeholder="Enter votre nom et prénom">
                        </div>
                        <div class="mb-3">
                            <label for="register-email" class="form-label">E-mail *</label>
                            <input type="email" class="form-control" id="register-email" name="email" placeholder="Enter votre e-mail">
                        </div>
                        <div class="mb-3">
                            <label for="register-password" class="form-label">Mot de passe *</label>
                            <input type="password" class="form-control" id="register-password" name="password" placeholder="Enter votre mot de passe">
                        </div>
                        <div class="mb-3">
                            <label for="register-password_confirmation" class="form-label">Confirmer le mot de passe *</label>
                            <input type="password" class="form-control" id="register-password_confirmation" name="password_confirmation" placeholder="Enter votre mot de passe">
                        </div>
                        <p>Un lien permettant de définir un nouveau mot de passe sera envoyé à votre adresse e-mail.</p>
                        <p>Vos données personnelles seront utilisées pour soutenir votre expérience sur ce site Web, pour gérer l'accès à votre compte et à d'autres fins décrites dans notre <a href="#">politique de confidentialité</a>.</p>
                        <button type="submit" class="btn btn-primary">S'enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="class mb-1"></div>

    @endsection 