<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-3">
            @include('partials.admin-sidebar')
        </div>
        <div class="col-md-9">
            <h2>Gestion des commandes</h2>
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Produit</th>
                        <th>Date début</th>
                        <th>Date fin</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->user->name ?? '-' }}</td>
                            <td>{{ $order->product->title ?? '-' }}</td>
                            <td>{{ $order->start_date }}</td>
                            <td>{{ $order->end_date }}</td>
                            <td>{{ $order->status }}</td>
                            <td>
                                <button class="btn btn-info btn-sm" wire:click="show('{{ $order->uuid }}')">Show</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if($selectedOrder)
                @php $formiptv = $selectedOrder->formiptvs->first(); @endphp
                <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,0.3);">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Détails de la commande</h5>
                                <button type="button" class="btn-close" wire:click="closeDetails"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Client :</strong> {{ $selectedOrder->user->name ?? '-' }}</p>
                                <p><strong>Produit :</strong> {{ $selectedOrder->product->title ?? '-' }}</p>
                                <p><strong>Quantité :</strong> {{ $selectedOrder->quantity ?? '-' }}</p>
                                <p><strong>Durée :</strong> {{ $formiptv->duration ?? '-' }}</p>
                                <p><strong>VODs :</strong> {{ $formiptv->vods ?? '-' }}</p>
                                <p><strong>Devices :</strong> {{ $formiptv->device ?? '-' }}</p>
                                <p><strong>Application :</strong> {{ $formiptv->application ?? '-' }}</p>
                                <p><strong>Bouquet :</strong> {{ $formiptv->bouquet ?? '-' }}</p>
                                <p><strong>Date début :</strong> {{ $selectedOrder->start_date }}</p>
                                <p><strong>Date fin :</strong> {{ $selectedOrder->end_date }}</p>
                                <p><strong>Statut :</strong> {{ $selectedOrder->status }}</p>
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