@extends('layouts.main')

@section('title', 'Mon Dashboard')

@section('content')
<div class="dashboard-container">
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h2 class="sidebar-title">Mon Dashboard</h2>
            <p class="user-welcome">Bienvenue, {{ auth()->user()->name }}</p>
        </div>
        
        <ul class="sidebar-menu">
            <li class="sidebar-item">
                <a href="#" class="sidebar-link" data-section="profile" onclick="showSection('profile')">
                    <span class="sidebar-icon">👤</span>
                    Mes Informations
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link" data-section="commandes" onclick="showSection('commandes')">
                    <span class="sidebar-icon">📦</span>
                    Mes Commandes
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link" data-section="panier" onclick="showSection('panier')">
                    <span class="sidebar-icon">🛒</span>
                    Mon Panier
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link" data-section="support" onclick="showSection('support')">
                    <span class="sidebar-icon">🛠️</span>
                    Support
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        {{-- Success/Error Messages --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <!-- Profile Section - Mes Informations Personnelles -->
        <section class="content-section" id="profile" style="display: block;">
            @include('dashboard.sections.profile')
        </section>

        <!-- Commandes Section - From Subscriptions -->
        <section class="content-section" id="commandes" style="display: none;">
            @include('dashboard.sections.orders')
        </section>

        <!-- Panier Section - Session Based -->
        <section class="content-section" id="panier" style="display: none;">
            @include('dashboard.sections.cart')
        </section>

        <!-- Support Section -->
        <section class="content-section" id="support" style="display: none;">
            @include('dashboard.sections.support')
        </section>
    </main>
</div>

@include('dashboard.components.scripts')
@include('dashboard.components.styles')
@endsection