<div class="section-header">
    <h1 class="section-title">Mes Commandes</h1>
    <p class="section-subtitle">Historique de vos achats et formations</p>
</div>

@if($subscriptions->count() > 0)
    <div class="grid">
        @foreach($subscriptions as $subscription)
            <div class="card">
                <h3 class="card-title">Commande #{{ $subscription->number_order }}</h3>
                
                <!-- Nom de la formation -->
                @if($subscription->product)
                    <div class="formation-info">
                        <h4 class="formation-title">{{ $subscription->product->title }}</h4>
                        <div class="formation-meta">
                            <span class="formation-price">{{ number_format($subscription->product->price, 2) }}€</span>
                            @if($subscription->product->category)
                                <span class="formation-category">{{ $subscription->product->category->name }}</span>
                            @endif
                        </div>
                    </div>
                @endif
                
                <div class="card-meta">
                    <strong>Date début:</strong> {{ $subscription->start_date }}<br>
                    <strong>Date fin:</strong> {{ $subscription->end_date }}<br>
                    <strong>Quantité:</strong> {{ $subscription->quantity }}<br>
                    <strong>Status:</strong> {{ $subscription->status }}<br>
                </div>

                <div class="card-description">
                    <strong>Note:</strong><br>
                    {{ $subscription->note ?? 'Aucune note.' }}
                </div>

                <!-- Product Option -->
                @if($subscription->productOption)
                    <div><strong>Option Produit:</strong> {{ $subscription->productOption->name }}</div>
                @endif

                <!-- Application Type -->
                @if($subscription->applicationType)
                    <div><strong>Type d'application:</strong> {{ $subscription->applicationType->name }}</div>
                @endif

                <!-- Device Type -->
                @if($subscription->deviceType)
                    <div><strong>Type de device:</strong> {{ $subscription->deviceType->name }}</div>
                @endif

                <!-- VODs -->
                @if($subscription->formiptvs && $subscription->formiptvs->count() > 0)
                    <div><strong>VODs:</strong>
                        <ul>
                            @foreach($subscription->formiptvs as $formiptv)
                                @if($formiptv->vods)
                                    <li>{{ $formiptv->vods }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Infos MAC -->
                <div>
                    @if($subscription->macaddress)
                        <div><strong>MAC Address:</strong> {{ $subscription->macaddress }}</div>
                    @endif

                    @if($subscription->magaddress)
                        <div><strong>MAG Address:</strong> {{ $subscription->magaddress }}</div>
                    @endif

                    @if($subscription->formulermac)
                        <div><strong>Formuler MAC:</strong> {{ $subscription->formulermac }}</div>
                    @endif

                    @if($subscription->formulermag)
                        <div><strong>Formuler MAG:</strong> {{ $subscription->formulermag }}</div>
                    @endif
                </div>
                
                <div style="margin-top: 1rem;">
                    @if($subscription->product)
                        <a href="{{ route('product.details', $subscription->product->uuid) }}" class="btn">Voir Formation</a>
                    @endif
                    <a href="{{ route('order.details', $subscription->uuid) }}" class="btn btn-secondary" style="margin-left: 0.5rem;">Détails Commande</a>
                    <button onclick="downloadInvoice('{{ $subscription->uuid }}')" class="btn btn-secondary" style="margin-left: 0.5rem;">Télécharger facture</button>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="empty-state">
        <div class="empty-state-icon">📦</div>
        <h3>Aucune commande trouvée</h3>
        <p>Vous n'avez pas encore passé de commande.</p>
    </div>
@endif 