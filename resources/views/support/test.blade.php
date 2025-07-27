@extends('layouts.dashboard')

@section('title', 'Test Support')

@section('content')
<div class="dashboard-content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h5><i class="fas fa-headset me-2"></i> Test Support</h5>
                    </div>
                    <div class="card-body">
                        <h3>Test de la page Support</h3>
                        <p>Si vous voyez ce message, le layout dashboard fonctionne correctement.</p>
                        <a href="{{ route('support.index') }}" class="btn btn-primary">
                            <i class="fas fa-list me-2"></i>
                            Aller à la liste des tickets
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 