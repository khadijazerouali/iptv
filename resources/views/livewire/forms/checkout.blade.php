<div class="row">
    <!-- Formulaire de facturation -->
    <div class="col-md-7">
        <h2>Détails De Facturation</h2>
        <form wire:submit.prevent="submit">
            @csrf
            <div class="mb-3">
                <label for="nom">Nom *</label>
                <input type="text" class="form-control" id="nom" name="nom" wire:model="nom" required>
            </div>
            <div class="mb-3">
                <label for="prenom">Prénom *</label>
                <input type="text" class="form-control" id="prenom" name="prenom" wire:model="prenom" required>
            </div>
            <div class="mb-3">
                <label for="nom_entreprise">Nom de l'entreprise (facultatif)</label>
                <input type="text" class="form-control" id="nom_entreprise" name="nom_entreprise" wire:model="nom_entreprise">
            </div>
            <div class="mb-3">
                <label for="email">E-mail *</label>
                <input type="email" class="form-control" id="email" name="email" wire:model="email" required>
            </div>
            <div class="mb-3">
                <label for="pays">Pays/Région *</label>
                <select id="pays" name="pays" class="form-control" wire:model="pays" required>
                    <option value="">Sélectionnez un pays</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country }}">{{ $country }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="rue">Numéro et nom de rue *</label>
                <input type="text" class="form-control" id="rue" name="rue" wire:model="rue" required>
            </div>
            <!-- <div class="mb-3">
                <label for="code_postal">Code postal *</label>
                <input type="text" class="form-control" id="code_postal" name="code_postal" wire:model="code_postal">
            </div> -->
            <div class="mb-3">
                <label for="ville">Ville *</label>
                <input type="text" class="form-control" id="ville" name="ville" wire:model="ville" required>
            </div>
            <div class="mb-3">
                <label for="telephone">Whatsapp *</label>
                <input type="text" class="form-control" id="telephone" name="telephone" wire:model="telephone" required>
            </div>
            <div class="mb-3">
                <label for="order_notes">Informations Complémentaires</label>
                <textarea id="order_notes" name="commentaire" class="form-control" rows="4" wire:model="commentaire"></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-3">Commander</button>
        </form>
    </div>

    <!-- Résumé de la commande -->
    <div class="col-md-5">
        <h4>Mode de paiement</h4>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment_method" id="card" wire:model="payment_method" value="card" checked>
            <label class="form-check-label" for="card">💳 Paiement par Carte Bancaire</label>
        </div>
        <p class="small text-muted">Vos données personnelles de votre Carte Bancaire ne seront jamais enregistrées sur notre site.</p>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment_method" id="paypal" wire:model="payment_method" value="paypal">
            <label class="form-check-label" for="paypal">🅿️ Paiement par PayPal</label>
        </div>
        <p class="small text-muted">Vos données personnelles seront utilisées pour traiter votre commande et soutenir votre expérience sur ce site.</p>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment_method" id="virement" wire:model="payment_method" value="virement">
            <label class="form-check-label" for="virement">💳 Paiement par Virement Bancaire</label>
        </div>
        <p class="small text-muted">Vos données personnelles de votre Virement Bancaire seront utilisées pour traiter votre commande et soutenir votre expérience sur ce site.</p>
        <br>

        <h2>Votre Commande</h2>
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th>Produit</th>
                    <th class="text-end">Sous-total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>{{ $product->title }} 
                        @if ($selectedOptionName && $selectedOptionName != '-')
                            – {{ $selectedOptionName }}
                        @endif
                        </strong> × {{ $quantity ?? 1 }}</td>
                    <td class="text-end">{{ number_format($total, 2) }} €</td>
                </tr>
                @if ($productType === 'abonnement' || $productType === 'testiptv' || $productType === 'application')
                    @if (!empty($device_id))
                        <tr>
                            <td><strong>Device ID :</strong> </td>
                            <td class="text-end">{{ $device_id }}</td>
                        </tr>
                    @endif
                    @if (!empty($device_key))
                        <tr>
                            <td><strong>Device Key :</strong> </td>
                            <td class="text-end">{{ $device_key }}</td>
                        </tr>
                    @endif
                    @if (!empty($macaddress))
                        <tr>
                            <td><strong>MAC Address :</strong> </td>
                            <td class="text-end">{{ $macaddress }}</td>
                        </tr>
                    @endif
                    @if (!empty($magaddress))
                        <tr>
                            <td><strong>Mag Address :</strong> </td>
                            <td class="text-end">{{ $magaddress }}</td>
                        </tr>
                    @endif
                    @if (!empty($formulermac))
                        <tr>
                            <td><strong>Formulaire MAC :</strong> </td>
                            <td class="text-end">{{ $formulermac }}</td>
                        </tr>
                    @endif
                    @if (!empty($smartstbmac))
                        <tr>
                            <td><strong>Smart STB MAC :</strong> </td>
                            <td class="text-end">{{ $smartstbmac }}</td>
                        </tr>
                    @endif
                @elseif ($productType === 'revendeur' || $productType === 'renouvellement')
                    @if (!empty($number_order))
                        <tr>
                            <td><strong>Numéro de commande :</strong> </td>
                            <td class="text-end">{{ $number_order }}</td>
                        </tr>
                    @endif
                    @if (!empty($first_name) && !empty($last_name))
                        <tr>
                            <td><strong>Nom :</strong> </td>
                            <td class="text-end">{{ $first_name }} {{ $last_name }}</td>
                        </tr>
                        <tr>
                            <td><strong>E-mail :</strong> </td>
                            <td class="text-end">{{ $email }}</td>
                        </tr>
                    @endif
                @endif
                <tr>
                    <th>Total</th>
                    <th class="text-end">{{ number_format($total, 2) }} €</th>
                </tr>
            </tbody>
        </table>
    </div>
</div>