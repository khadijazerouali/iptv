<div>
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

    <!-- VOD -->
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
</div>