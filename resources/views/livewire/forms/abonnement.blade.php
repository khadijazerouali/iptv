
<form wire:submit.prevent="submitForm">        
    @csrf

    <!-- Duration -->
    <div class="my-3">
        Durée Abonnement :
        @if($selectedPrice)
            <p class="fw-semibold text-primary fs-4">{{ $selectedPrice }} €</p>
        @else
            @if($product->old_price)
                <p class="fw-semibold text-primary fs-4"><del>{{ $product->old_price }} €</del></p>
            @endif
            <p class="fw-semibold text-primary fs-4">{{ $product->price }} €</p>
        @endif

        @if($product->productOptions->isNotEmpty())
            <select class="form-select" wire:model="selectedOptionUuid" name="selectedOptionUuid" wire:model.live="selectedOptionUuid" required>
                <option value="">Choisir une option</option>
                @foreach ($product->productOptions as $option)
                    <option value="{{ $option->uuid }}">
                        {{ $option->name }} - {{ $option->price }} €
                    </option>
                @endforeach
            </select>
        @endif
    </div>

    <!-- Device Selection -->
    <div class="mb-3">
        <label class="form-label">Dispositif d'abonnement IPTV :</label>
        <select class="form-select" wire:model="selectedDevice" name="selectedDevice" wire:model.live="selectedDevice" required>
            <option value="">Sélectionnez un dispositif</option>
            @foreach ($deviceTypes as $deviceType)
                <option value="{{ $deviceType->uuid }}">{{ $deviceType->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Application Selection -->
    @if (!$applicationTypes->isEmpty())
        <div class="mb-3">
            <label class="form-label">Votre application :</label>
            <select class="form-select" wire:model="selectedApplication" name="selectedApplication" wire:model.live="selectedApplication">
                <option value="">Sélectionnez une application</option>
                @foreach ($applicationTypes as $applicationType)
                    <option value="{{ $applicationType->uuid }}">{{ $applicationType->name }}</option>
                @endforeach
            </select>
        </div>
    @endif

    <!-- Device-Specific Fields -->
    @if ($deviceSelected)
        @if ($deviceSelected->macaddress)
            <div class="mb-3">
                <label class="form-label">Adresse MAC :</label>
                <input type="text" class="form-control" name="macaddress" wire:model="macaddress" required>
            </div>
        @endif
        @if ($deviceSelected->magaddress)
            <div class="mb-3">
                <label class="form-label">Adresse Mag :</label>
                <input type="text" class="form-control" name="magaddress" wire:model="magaddress" required>
            </div>
        @endif
        @if ($deviceSelected->formulermac)
            <div class="mb-3">
                <label class="form-label">Adresse Formulaire MAC :</label>
                <input type="text" class="form-control" name="formulermac" wire:model="formulermac" required>
            </div>
        @endif
    @endif

    <!-- Application-Specific Fields -->
    @if ($applicationSelected)
        @if ($applicationSelected->deviceid)
            <div class="mb-3">
                <label class="form-label">Device ID :</label>
                <input type="text" class="form-control" name="deviceid" wire:model="deviceid" required>
            </div>
        @endif
        @if ($applicationSelected->devicekey)
            <div class="mb-3">
                <label class="form-label">Device Key :</label>
                <input type="text" class="form-control" name="devicekey" wire:model="devicekey" required>
            </div>
        @endif
        @if ($applicationSelected->otpcode)
            <div class="mb-3">
                <label class="form-label">OTP Code :</label>
                <input type="text" class="form-control" name="otpcode" wire:model="otpcode" required>
            </div>
        @endif
        @if ($applicationSelected->smartstbmac)
            <div class="mb-3">
                <label class="form-label">Adresse Smart STB MAC :</label>
                <input type="text" class="form-control" name="smartstbmac" wire:model="smartstbmac" required>
            </div>
        @endif
    @endif

    <!-- Channels -->
    <div class="mb-3">
        <label class="form-label">Sélectionnez vos bouquets de chaînes :</label>
        <div class="row">
            @foreach ($channelList as $channel)
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" wire:model="channels" name="channels[]" value="{{ $channel->uuid }}"
                            id="channel-{{ Str::slug($channel->title) }}">
                        <label class="form-check-label" for="channel-{{ Str::slug($channel->title) }}">
                            {{ $channel->title }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
        <small class="text-danger d-block mt-2">
            <span class="text-black fw-bold">NB :</span> Certaines applications et anciennes versions de MAG et Smart TV
            peuvent ne pas supporter de grandes playlists. Pour de meilleures performances, limitez à 6 bouquets.
        </small>
    </div>

    <!-- VODs -->
    <div class="mb-3">
        <label class="form-label">Vidéos à la demande :</label>
        <div class="row">
            @foreach ($vodOptions as $vod)
                <div class="col-md-3 mb-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="vods[]" value="{{ $vod->uuid }}"
                            wire:model="vods" id="vod-{{ Str::slug($vod->title) }}">
                        <label class="form-check-label" for="vod-{{ Str::slug($vod->title) }}">
                            {{ $vod->title }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="row">
        <!-- Quantity Selector -->
        <div class="col-md-1 d-flex align-items-center mb-3">
            <div class="counter">
                <button type="button" class="counter-btn" wire:click="increment">&#x25B2;</button>
                <input type="number" class="counter-input" wire:model="quantity" min="1" max="99" >
                <button type="button" class="counter-btn" wire:click="decrement">&#x25BC;</button>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="col-md-6 d-flex align-items-center mb-3 ms-4">
            <button type="submit" wire:click="submitForm" class="btn btn-primary btn-lg w-100 d-flex justify-content-center align-items-center">
                COMMANDER MAINTENANT
                <i class="bi bi-plus-circle ms-2"></i>
            </button>
        </div>
    </div>
    
</form>