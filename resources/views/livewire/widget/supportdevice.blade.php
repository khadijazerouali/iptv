<div class="container my-5 scrolling-row-container">
        <div class="scrolling-row">
            @foreach($supportedDevices as $device)
            <img src="{{ $device['image'] }}" alt="{{ $device['alt'] }}">
            @endforeach
        </div>
    </div>