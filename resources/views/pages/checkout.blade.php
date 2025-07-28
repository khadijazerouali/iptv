@extends('layouts.main')

@section('title', 'Checkout')

@section('content')
<div class="container my-5">
    <!-- Message de confirmation -->
    @if (session('success'))
        <div class="alert alert-success">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            ❌ {{ session('error') }}
        </div>
    @endif
    @if (session('message'))
        <div class="alert alert-info">
            🛒 {{ session('message') }}
        </div>
    @endif

    <div class="alert alert-info">
        🔹 Déjà client ? <a href="#" id="show-login-form">Cliquez ici pour vous connecter</a>
    </div>
    <div id="login-form" style="display: none;">
        <livewire:forms.checkout.login-form />
    </div>

    <!-- Code promo -->
    <div class="alert alert-info">
        🔹 Avez-vous un code promo ? <a href="#" id="show-coupon-form">Cliquez ici pour saisir votre code</a>
    </div>
    <!-- Coupon Form -->
    <div id="coupon-form" style="display: none;">
        <livewire:forms.checkout.coupon-form />
    </div>

    <livewire:forms.checkout :countries="$countries" :product="$product" />

    
</div>

<script>
    document.getElementById('show-coupon-form').addEventListener('click', function(event) {
        event.preventDefault();
        var couponForm = document.getElementById('coupon-form');
        if (couponForm.style.display === 'none' || couponForm.style.display === '') {
            couponForm.style.display = 'block';
        } else {
            couponForm.style.display = 'none';
        }
    });

    document.getElementById('show-login-form').addEventListener('click', function(event) {
        event.preventDefault();
        var loginForm = document.getElementById('login-form');
        if (loginForm.style.display === 'none' || loginForm.style.display === '') {
            loginForm.style.display = 'block';
        } else {
            loginForm.style.display = 'none';
        }
    });
</script>
@endsection