<div>
    <div class="mb-3">
        <label class="form-label">Dispositif d'abonnement IPTV :</label>
        <select class="form-select" wire:model="selectedDevice" name="selectedDeviceType" wire:model.live="selectedDeviceType" required>
            <option value="">Sélectionnez un dispositif</option>
            @foreach ($deviceTypes as $deviceType)
                <option value="{{ $deviceType->uuid }}">
                    {{ $deviceType->name }}
                </option>
            @endforeach
        </select>
    </div>
    @if (!$applicationTypes->isEmpty())
        <div class="mb-3">
            <label class="form-label">Votre application :</label>
            <select class="form-select" wire:model="selectedApplication" name="selectedApplicationType" wire:model.live="selectedApplicationType" required>
                <option value="">Sélectionnez une application</option>
                @foreach ($applicationTypes as $applicationType)
                    <option value="{{ $applicationType->uuid }}">
                        {{ $applicationType->name }}
                    </option>
                @endforeach
            </select>
        </div>
    @endif

    @if ($deviceSelected)
        @if ($deviceSelected->macaddress)
            <div class="mb-3">
                <label class="form-label">Adresse MAC :</label>
                <input type="text" class="form-control"      name="macaddress" wire:model="macaddress" required>
            </div>
        @endif
        @if ($deviceSelected->magaddress)
            <div class="mb-3">
                <label class="form-label">Adresse Mag :</label>
                <input type="text" class="form-control"  name="magaddress" wire:model="magaddress" required>
            </div>
        @endif
        @if ($deviceSelected->formulermac)
            <div class="mb-3">
                <label class="form-label">Adresse Formulaire MAC :</label>
                <input type="text" class="form-control" name="formulermac" wire:model="formulermac" required>
            </div>
        @endif
    @endif

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
</div>