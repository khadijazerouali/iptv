<div>
    <div class="my-3">
        <select class="form-select" id="quantitySelect" name="duration" wire:model="duration" required>
            <option value="">Choisir une option</option>
            <option value="1">1 mois</option>
            <option value="3">3 mois</option>
            <option value="6">6 mois</option>
            <option value="12">12 mois</option>
        </select>
    </div>

    <div class="container my-4">
        <!-- Sélection du dispositif -->
        <div class="mb-3">
            <label for="device" class="form-label">Dispositif d'abonnement IPTV :</label>
            <select class="form-select" id="device" name="device_uuid" wire:model="device_uuid" required>
                <option value="">Sélectionnez un dispositif</option>
                @foreach ($deviceTypes as $deviceType)
                <option value="{{ $deviceType->uuid }}">{{ $deviceType->name }}</option>
                @endforeach
            </select>
        </div>

        @if($device_uuid)
        <!-- Sélection de l'application -->
        @if($validApplications->isNotEmpty())
        <div class="mb-3">
            <label for="application" class="form-label">Votre application :</label>
            <select class="form-select" id="application" name="application_uuid" wire:model="application_uuid" required>
                <option value="">Sélectionnez une application</option>
                @foreach ($validApplications as $application)
                <option value="{{ $application->uuid }}">{{ $application->name }}</option>
                @endforeach
            </select>
        </div>
        @endif
        @endif

        <!-- Sélection des bouquets -->
        <div class="mb-3">
            <label class="form-label">Sélectionnez vos bouquets de chaînes :</label>
            <div class="row">
                @foreach ($channels as $channel)
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="channels[]" value="{{ $channel->uuid }}"
                            wire:model="channels" id="channel-{{ $channel->uuid }}">
                        <label class="form-check-label" for="channel-{{ $channel->uuid }}">
                            {{ $channel->title }}
                        </label>
                    </div>
                </div>
                @endforeach
            </div>
            <br>
            <small class="text-danger"><span class="text-black">NB :</span> Notez que certaines applications et
                anciennes versions de MAG et Smart TV pourront ne pas supporter une très grande Playlist, pour une
                meilleure performance et rapidité de chargement de vos chaînes, veuillez ne pas dépasser 6
                bouquets.</small>
        </div>

        <!-- Sélection de VOD -->
        <div class="mb-3">
            <label class="form-label">Vidéos à la demande :</label>
            <div class="row">
                @foreach ($vods as $vod)
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="vods[]" value="{{ $vod->uuid }}"
                            wire:model="vods" id="vod-{{ $vod->uuid }}">
                        <label class="form-check-label" for="vod-{{ $vod->uuid }}">
                            {{ $vod->title }}
                        </label>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <br>

        <!-- Produit et quantité -->
        <input type="hidden" name="product_uuid" value="{{ $product_uuid }}">
        <input type="hidden" name="price" value="{{ $price }}">

        <div class="d-flex align-items-center">
            <div class="counter">
                <button type="button" class="counter-btn" wire:click="increment">&#x25B2;</button>
                <input type="number" class="counter-input" id="counterInput" value="{{ $number }}" min="1" max="99"
                    readonly>
                <button type="button" class="counter-btn" wire:click="decrement">&#x25BC;</button>
            </div>

            <input type="hidden" name="number" id="numberInput" value="{{ $number }}">

            <button type="button" class="btn btn-primary btn-lg d-flex align-items-center ms-4"
                style="border-radius: 40px;" wire:click="submitForm">
                COMMANDER MAINTENANT
                <span class="ms-2"><i class="bi bi-plus-circle"></i></span>
            </button>
        </div>
    </div>
</div>