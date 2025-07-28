<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-3">
            @include('partials.admin-sidebar')
        </div>
        <div class="col-md-9">
            <!-- Header Section -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1 text-dark fw-bold">
                        <i class="fas fa-shopping-cart me-2 text-primary"></i>
                        Gestion des commandes
                    </h2>
                    <p class="text-muted mb-0">Gérez toutes les commandes de vos clients</p>
                </div>
                <div class="d-flex gap-2">
                    <div class="input-group" style="width: 300px;">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Rechercher une commande..." wire:model.live="search">
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                        <i class="fas fa-shopping-bag text-primary fs-4"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="card-title text-muted mb-1">Total Commandes</h6>
                                    <h4 class="mb-0 fw-bold text-dark">{{ $orders->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                        <i class="fas fa-clock text-warning fs-4"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="card-title text-muted mb-1">En attente</h6>
                                    <h4 class="mb-0 fw-bold text-dark">{{ $orders->where('status', 'pending')->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                        <i class="fas fa-check-circle text-success fs-4"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="card-title text-muted mb-1">Actives</h6>
                                    <h4 class="mb-0 fw-bold text-dark">{{ $orders->where('status', 'active')->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                        <i class="fas fa-euro-sign text-info fs-4"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="card-title text-muted mb-1">Chiffre d'affaires</h6>
                                    <h4 class="mb-0 fw-bold text-dark">{{ number_format($orders->sum(function($order) { return $order->product->price * $order->quantity; }), 2) }}€</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-list me-2 text-primary"></i>
                        Liste des commandes
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 py-3 px-4 fw-semibold text-dark"># Commande</th>
                                    <th class="border-0 py-3 px-4 fw-semibold text-dark">Client</th>
                                    <th class="border-0 py-3 px-4 fw-semibold text-dark">Produit</th>
                                    <th class="border-0 py-3 px-4 fw-semibold text-dark">Configuration</th>
                                    <th class="border-0 py-3 px-4 fw-semibold text-dark">Prix</th>
                                    <th class="border-0 py-3 px-4 fw-semibold text-dark">Statut</th>
                                    <th class="border-0 py-3 px-4 fw-semibold text-dark">Date</th>
                                    <th class="border-0 py-3 px-4 fw-semibold text-dark">Actions</th>
                    </tr>
                </thead>
                <tbody>
                                @forelse($orders as $order)
                                    <tr class="border-bottom">
                                        <td class="py-3 px-4">
                                            <span class="fw-bold text-primary">#{{ $order->number_order }}</span>
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                                        <i class="fas fa-user text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="fw-semibold text-dark">{{ $order->user->name ?? '-' }}</div>
                                                    <small class="text-muted">{{ $order->user->email ?? '-' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4">
                                            <div>
                                                <div class="fw-semibold text-dark">{{ $order->product->title ?? '-' }}</div>
                                                <small class="text-muted">
                                                    <i class="fas fa-cube me-1"></i>
                                                    Qty: {{ $order->quantity }}
                                                </small>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="d-flex flex-column gap-1">
                                                @if($order->formiptvs && $order->formiptvs->count() > 0)
                                                    @foreach($order->formiptvs as $formiptv)
                                                        @if($formiptv->duration)
                                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">{{ $formiptv->duration }}</span>
                                                        @endif
                                                        @if($formiptv->device)
                                                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">{{ $formiptv->device }}</span>
                                                        @endif
                                                        @if($formiptv->application)
                                                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25">{{ $formiptv->application }}</span>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-3 px-4">
                                            @if($order->hasPromoCode())
                                                <div class="price-breakdown">
                                                    <div class="original-price">
                                                        <span class="text-muted text-decoration-line-through small">
                                                            {{ number_format($order->original_price, 2) }}€
                                                        </span>
                                                    </div>
                                                    <div class="final-price">
                                                        <span class="fw-bold text-success fs-6">
                                                            {{ number_format($order->final_price, 2) }}€
                                                        </span>
                                                    </div>
                                                    <div class="discount-info">
                                                        <small class="text-success">
                                                            <i class="fas fa-tag me-1"></i>
                                                            {{ $order->promo_code }} 
                                                            (-{{ number_format($order->discount_amount, 2) }}€)
                                                        </small>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="fw-bold text-success fs-6">{{ number_format($order->product->price, 2) }}€</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4">
                                            @php
                                                $statusColors = [
                                                    'active' => 'success',
                                                    'pending' => 'warning',
                                                    'inactive' => 'danger',
                                                    'cancelled' => 'secondary'
                                                ];
                                                $statusColor = $statusColors[$order->status] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $statusColor }} bg-opacity-10 text-{{ $statusColor }} border border-{{ $statusColor }} border-opacity-25 px-3 py-2">
                                                <i class="fas fa-circle me-1" style="font-size: 8px;"></i>
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="text-muted">
                                                <div>{{ $order->start_date->format('d/m/Y') }}</div>
                                                <small>{{ $order->start_date->format('H:i') }}</small>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4">
                                            <button class="btn btn-outline-primary btn-sm" wire:click="show('{{ $order->uuid }}')">
                                                <i class="fas fa-eye me-1"></i>
                                                Détails
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                                <h5>Aucune commande trouvée</h5>
                                                <p>Il n'y a pas encore de commandes dans le système.</p>
                                            </div>
                            </td>
                        </tr>
                                @endforelse
                </tbody>
            </table>
                    </div>
                </div>
            </div>
            @if($selectedOrder)
                <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,0.5); backdrop-filter: blur(5px);">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content border-0 shadow-lg">
                            <div class="modal-header bg-gradient-primary text-white border-0">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-white bg-opacity-20 rounded-circle p-2">
                                            <i class="fas fa-shopping-cart text-white"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="modal-title mb-1 fw-bold">Détails de la commande #{{ $selectedOrder->number_order }}</h5>
                                        <small class="opacity-75">Informations complètes de la commande</small>
                                    </div>
                                </div>
                                <button type="button" class="btn-close btn-close-white" wire:click="closeDetails"></button>
                            </div>
                            <div class="modal-body p-4">
                                <!-- Informations client et commande -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="card border-0 shadow-sm h-100">
                                            <div class="card-header bg-light border-0">
                                                <h6 class="mb-0 fw-bold text-dark">
                                                    <i class="fas fa-user me-2 text-primary"></i>
                                                    Informations client
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                        <i class="fas fa-user text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold text-dark">{{ $selectedOrder->user->name ?? '-' }}</div>
                                                        <small class="text-muted">{{ $selectedOrder->user->email ?? '-' }}</small>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <small class="text-muted d-block">Téléphone</small>
                                                        <div class="fw-semibold">{{ $selectedOrder->user->telephone ?? '-' }}</div>
                                                    </div>
                                                    <div class="col-6">
                                                        <small class="text-muted d-block">Ville</small>
                                                        <div class="fw-semibold">{{ $selectedOrder->user->ville ?? '-' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card border-0 shadow-sm h-100">
                                            <div class="card-header bg-light border-0">
                                                <h6 class="mb-0 fw-bold text-dark">
                                                    <i class="fas fa-info-circle me-2 text-primary"></i>
                                                    Informations commande
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                                        <i class="fas fa-receipt text-success"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold text-dark">#{{ $selectedOrder->number_order }}</div>
                                                        <small class="text-muted">{{ $selectedOrder->created_at->format('d/m/Y H:i') }}</small>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <small class="text-muted d-block">Statut</small>
                                                        @php
                                                            $statusColors = [
                                                                'active' => 'success',
                                                                'pending' => 'warning',
                                                                'inactive' => 'danger',
                                                                'cancelled' => 'secondary'
                                                            ];
                                                            $statusColor = $statusColors[$selectedOrder->status] ?? 'secondary';
                                                        @endphp
                                                        <span class="badge bg-{{ $statusColor }} bg-opacity-10 text-{{ $statusColor }} border border-{{ $statusColor }} border-opacity-25">
                                                            <i class="fas fa-circle me-1" style="font-size: 8px;"></i>
                                                            {{ ucfirst($selectedOrder->status) }}
                                                        </span>
                                                    </div>
                                                    <div class="col-6">
                                                        <small class="text-muted d-block">Quantité</small>
                                                        <div class="fw-semibold">{{ $selectedOrder->quantity }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Produit commandé -->
                                @if($selectedOrder->product)
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-header bg-light border-0">
                                                <h6 class="mb-0 fw-bold text-dark">
                                                    <i class="fas fa-box me-2 text-primary"></i>
                                                    Produit commandé
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex align-items-start">
                                                    <div class="bg-info bg-opacity-10 rounded-circle p-3 me-3">
                                                        <i class="fas fa-box text-info fs-4"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h5 class="fw-bold text-dark mb-2">{{ $selectedOrder->product->title }}</h5>
                                                        <p class="text-muted mb-3">{{ $selectedOrder->product->description }}</p>
                                                        <div class="d-flex align-items-center">
                                                            <span class="fw-bold text-success fs-5 me-3">{{ number_format($selectedOrder->product->price, 2) }}€</span>
                                                            @if($selectedOrder->product->category)
                                                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25">
                                                                    {{ $selectedOrder->product->category->name }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Configuration de l'abonnement -->
                                @if($selectedOrder->formiptvs && $selectedOrder->formiptvs->count() > 0)
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-header bg-light border-0">
                                                <h6 class="mb-0 fw-bold text-dark">
                                                    <i class="fas fa-cogs me-2 text-primary"></i>
                                                    Configuration de l'abonnement
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                @foreach($selectedOrder->formiptvs as $formiptv)
                                                    <!-- Durée d'abonnement -->
                                                    @if($formiptv->duration)
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <div class="card border-0 bg-light">
                                                                <div class="card-body">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                                            <i class="fas fa-calendar text-primary"></i>
                                                                        </div>
                                                                        <div>
                                                                            <small class="text-muted d-block">Durée Abonnement</small>
                                                                            <div class="fw-semibold text-dark">{{ $formiptv->duration }}</div>
                                                                            <small class="text-success">{{ number_format($formiptv->price, 2) }}€</small>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif

                                                    <!-- Informations techniques -->
                                                    @if($formiptv->device || $formiptv->application)
                                                    <div class="row mb-3">
                                                        <div class="col-12">
                                                            <h6 class="fw-bold text-dark mb-3">
                                                <i class="fas fa-microchip me-2 text-primary"></i>
                                                Informations techniques
                                            </h6>
                                            <div class="row">
                                                @if($formiptv->device)
                                                <div class="col-md-6 mb-3">
                                                    <div class="card border-0 bg-light">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center">
                                                                <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                                                                    <i class="fas fa-tv text-info"></i>
                                                                </div>
                                                                <div>
                                                                    <small class="text-muted d-block">Device Name</small>
                                                                    <div class="fw-semibold text-dark">{{ $formiptv->device }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                
                                                @if($formiptv->application)
                                                <div class="col-md-6 mb-3">
                                                    <div class="card border-0 bg-light">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center">
                                                                <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                                                    <i class="fas fa-mobile-alt text-warning"></i>
                                                                </div>
                                                                <div>
                                                                    <small class="text-muted d-block">Application Name</small>
                                                                    <div class="fw-semibold text-dark">{{ $formiptv->application }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                                    <!-- Bouquets et VODs -->
                                                    @if($formiptv->channels || $formiptv->vods)
                                                    <div class="row mb-3">
                                                        <div class="col-12">
                                                            <h6 class="fw-bold text-dark mb-3">
                                                                <i class="fas fa-list me-2 text-primary"></i>
                                                                Bouquets et VODs sélectionnés
                                                            </h6>
                                                            <div class="row">
                                                                @if($formiptv->channels)
                                                                <div class="col-md-6">
                                                                    <div class="card border-0 bg-light">
                                                                        <div class="card-header bg-primary bg-opacity-10 border-0">
                                                                            <h6 class="mb-0 fw-bold text-primary">
                                                                                <i class="fas fa-tv me-2"></i>
                                                                                Bouquets de chaînes
                                                                            </h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 me-1 mb-1">{{ $formiptv->channels }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif

                                                                @if($formiptv->vods)
                                                                <div class="col-md-6">
                                                                    <div class="card border-0 bg-light">
                                                                        <div class="card-header bg-success bg-opacity-10 border-0">
                                                                            <h6 class="mb-0 fw-bold text-success">
                                                                                <i class="fas fa-film me-2"></i>
                                                                                Vidéos à la demande
                                                                            </h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 me-1 mb-1">{{ $formiptv->vods }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif

                                                    <!-- Configuration technique -->
                                                    @if($formiptv->mac_address || $formiptv->device_id || $formiptv->device_key || $formiptv->formuler_mac || $formiptv->mag_adresse)
                                                    <div class="row mb-3">
                                                        <div class="col-12">
                                                            <h6 class="fw-bold text-dark mb-3">
                                                                <i class="fas fa-network-wired me-2 text-primary"></i>
                                                                Configuration technique
                                                            </h6>
                                                            <div class="row">
                                                                @if($formiptv->mac_address)
                                                                <div class="col-md-6 mb-2">
                                                                    <div class="d-flex align-items-center p-2 bg-light rounded">
                                                                        <i class="fas fa-wifi text-primary me-2"></i>
                                                                        <div>
                                                                            <small class="text-muted d-block">MAC Address</small>
                                                                            <code class="text-dark">{{ $formiptv->mac_address }}</code>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                @if($formiptv->device_id)
                                                                <div class="col-md-6 mb-2">
                                                                    <div class="d-flex align-items-center p-2 bg-light rounded">
                                                                        <i class="fas fa-fingerprint text-info me-2"></i>
                                                                        <div>
                                                                            <small class="text-muted d-block">Device ID</small>
                                                                            <code class="text-dark">{{ $formiptv->device_id }}</code>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                @if($formiptv->device_key)
                                                                <div class="col-md-6 mb-2">
                                                                    <div class="d-flex align-items-center p-2 bg-light rounded">
                                                                        <i class="fas fa-key text-warning me-2"></i>
                                                                        <div>
                                                                            <small class="text-muted d-block">Device Key</small>
                                                                            <code class="text-dark">{{ $formiptv->device_key }}</code>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                @if($formiptv->formuler_mac)
                                                                <div class="col-md-6 mb-2">
                                                                    <div class="d-flex align-items-center p-2 bg-light rounded">
                                                                        <i class="fas fa-ethernet text-success me-2"></i>
                                                                        <div>
                                                                            <small class="text-muted d-block">Formuler MAC</small>
                                                                            <code class="text-dark">{{ $formiptv->formuler_mac }}</code>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                @if($formiptv->mag_adresse)
                                                                <div class="col-md-6 mb-2">
                                                                    <div class="d-flex align-items-center p-2 bg-light rounded">
                                                                        <i class="fas fa-broadcast-tower text-danger me-2"></i>
                                                                        <div>
                                                                            <small class="text-muted d-block">MAG Adresse</small>
                                                                            <code class="text-dark">{{ $formiptv->mag_adresse }}</code>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Configuration spécifique à l'application -->
                                @if($selectedOrder->formiptvs && $selectedOrder->formiptvs->count() > 0)
                                @foreach($selectedOrder->formiptvs as $formiptv)
                                    @php
                                        $applicationType = \App\Models\Applicationtype::where('name', $formiptv->application)->first();
                                        $hasFields = false;
                                        if ($applicationType) {
                                            $hasFields = ($applicationType->deviceid && $formiptv->device_id) ||
                                                        ($applicationType->devicekey && $formiptv->device_key) ||
                                                        ($applicationType->otpcode && $formiptv->otp_code) ||
                                                        ($applicationType->smartstbmac && $formiptv->note);
                                        }
                                    @endphp
                                    
                                    @if($hasFields)
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <div class="card border-0 shadow-sm">
                                                <div class="card-header bg-light border-0">
                                                    <h6 class="mb-0 fw-bold text-dark">
                                                        <i class="fas fa-mobile-alt me-2 text-primary"></i>
                                                        Configuration spécifique à l'application
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        @if($applicationType && $applicationType->deviceid && $formiptv->device_id)
                                                        <div class="col-md-6 mb-3">
                                                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                                                <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                                                                    <i class="fas fa-fingerprint text-info"></i>
                                                                </div>
                                                                <div>
                                                                    <small class="text-muted d-block">Device ID</small>
                                                                    <code class="text-dark fw-semibold">{{ $formiptv->device_id }}</code>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif

                                                        @if($applicationType && $applicationType->devicekey && $formiptv->device_key)
                                                        <div class="col-md-6 mb-3">
                                                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                                                <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                                                    <i class="fas fa-key text-warning"></i>
                                                                </div>
                                                                <div>
                                                                    <small class="text-muted d-block">Device Key</small>
                                                                    <code class="text-dark fw-semibold">{{ $formiptv->device_key }}</code>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif

                                                        @if($applicationType && $applicationType->otpcode && $formiptv->otp_code)
                                                        <div class="col-md-6 mb-3">
                                                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                                                <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                                                    <i class="fas fa-shield-alt text-success"></i>
                                                                </div>
                                                                <div>
                                                                    <small class="text-muted d-block">OTP Code</small>
                                                                    <code class="text-dark fw-semibold">{{ $formiptv->otp_code }}</code>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif

                                                        @if($applicationType && $applicationType->smartstbmac && $formiptv->note)
                                                        <div class="col-md-6 mb-3">
                                                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                                                <div class="bg-danger bg-opacity-10 rounded-circle p-2 me-3">
                                                                    <i class="fas fa-broadcast-tower text-danger"></i>
                                                                </div>
                                                                <div>
                                                                    <small class="text-muted d-block">Smart STB MAC</small>
                                                                    <code class="text-dark fw-semibold">{{ $formiptv->note }}</code>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                                @endif

                                <!-- Période de validité -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-header bg-light border-0">
                                                <h6 class="mb-0 fw-bold text-dark">
                                                    <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                                    Période de validité
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="d-flex align-items-center">
                                                            <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                                                <i class="fas fa-play text-success"></i>
                                                            </div>
                                                            <div>
                                                                <small class="text-muted d-block">Date de début</small>
                                                                <div class="fw-semibold text-dark">{{ $selectedOrder->start_date->format('d/m/Y') }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="d-flex align-items-center">
                                                            <div class="bg-danger bg-opacity-10 rounded-circle p-2 me-3">
                                                                <i class="fas fa-stop text-danger"></i>
                                                            </div>
                                                            <div>
                                                                <small class="text-muted d-block">Date de fin</small>
                                                                <div class="fw-semibold text-dark">
                                                                    @if($selectedOrder->end_date)
                                                                        {{ $selectedOrder->end_date->format('d/m/Y') }}
                                                                    @else
                                                                        <span class="text-muted">Non définie</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Informations Complémentaires -->
                                @if($selectedOrder->note)
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-header bg-light border-0">
                                                <h6 class="mb-0 fw-bold text-dark">
                                                    <i class="fas fa-info-circle me-2 text-primary"></i>
                                                    Informations Complémentaires
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex align-items-start">
                                                    <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                                                        <i class="fas fa-plus-circle text-info"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <p class="mb-0 text-dark">{{ $selectedOrder->note }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif



                                <style>
                                .bg-gradient-primary {
                                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                                }
                                
                                .card {
                                    transition: all 0.3s ease;
                                }
                                
                                .card:hover {
                                    transform: translateY(-2px);
                                    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
                                }
                                
                                .badge {
                                    font-weight: 500;
                                    letter-spacing: 0.5px;
                                }
                                
                                .table-hover tbody tr:hover {
                                    background-color: rgba(102, 126, 234, 0.05);
                                    transform: scale(1.01);
                                    transition: all 0.2s ease;
                                }
                                
                                .btn-outline-primary:hover {
                                    transform: translateY(-1px);
                                    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
                                }
                                
                                .modal-content {
                                    border-radius: 15px;
                                }
                                
                                .modal-header {
                                    border-radius: 15px 15px 0 0;
                                }
                                
                                .rounded-circle {
                                    transition: all 0.3s ease;
                                }
                                
                                .card:hover .rounded-circle {
                                    transform: scale(1.1);
                                }
                                
                                .shadow-sm {
                                    box-shadow: 0 2px 8px rgba(0,0,0,0.08) !important;
                                }
                                
                                .shadow-lg {
                                    box-shadow: 0 10px 40px rgba(0,0,0,0.15) !important;
                                }
                                
                                .input-group-text {
                                    border-color: #e9ecef;
                                }
                                
                                .form-control:focus {
                                    border-color: #667eea;
                                    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
                                }
                                
                                .bg-opacity-10 {
                                    --bs-bg-opacity: 0.1;
                                }
                                
                                .border-opacity-25 {
                                    --bs-border-opacity: 0.25;
                                }
                                
                                /* Supprimer le double scrollbar */
                                .modal-body {
                                    overflow-y: auto;
                                    max-height: 70vh;
                                }
                                
                                .modal-body::-webkit-scrollbar {
                                    width: 8px;
                                }
                                
                                .modal-body::-webkit-scrollbar-track {
                                    background: #f1f1f1;
                                    border-radius: 4px;
                                }
                                
                                .modal-body::-webkit-scrollbar-thumb {
                                    background: #c1c1c1;
                                    border-radius: 4px;
                                }
                                
                                .modal-body::-webkit-scrollbar-thumb:hover {
                                    background: #a8a8a8;
                                }
                                
                                /* Masquer le scrollbar du body principal quand le modal est ouvert */
                                body.modal-open {
                                    overflow: hidden;
                                }
                                
                                /* S'assurer qu'il n'y a qu'un seul scrollbar */
                                .modal {
                                    overflow: hidden;
                                }
                                
                                .modal-dialog {
                                    overflow: hidden;
                                }
                                </style>

                                <!-- Configuration détaillée -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="fw-bold">Configuration de l'abonnement</h6>
                                        <div class="row">
                                            <!-- Durée d'abonnement -->
                                            @if($selectedOrder->productOption)
                                            <div class="col-md-6 mb-3">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <strong>Durée Abonnement</strong>
                                                    </div>
                                                    <div class="card-body">
                                                        <p class="mb-1">{{ $selectedOrder->productOption->name }}</p>
                                                        <p class="text-success fw-bold">{{ number_format($selectedOrder->productOption->price ?? $selectedOrder->product->price, 2) }}€</p>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            <!-- Type d'appareil -->
                                            @if($selectedOrder->deviceType)
                                            <div class="col-md-6 mb-3">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <strong>Dispositif IPTV</strong>
                                                    </div>
                                                    <div class="card-body">
                                                        <p class="mb-1">{{ $selectedOrder->deviceType->name }}</p>
                                                        @if($selectedOrder->deviceType->description)
                                                            <small class="text-muted">{{ $selectedOrder->deviceType->description }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" wire:click="closeDetails">Fermer</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div> 
