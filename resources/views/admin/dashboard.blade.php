@extends('layouts.main')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            @include('partials.admin-sidebar')
        </div>
        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card shadow-sm p-4">
                <h2 class="mb-4">Bienvenue sur le Dashboard Admin</h2>
                <p class="lead">Utilisez le menu à gauche pour gérer les utilisateurs, contacts, produits, catégories, commandes et le support.</p>
                <div class="alert alert-info mt-4">
                    <strong>Astuce :</strong> Sélectionnez une section dans la barre latérale pour commencer la gestion.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 