<div class="row g-4 my-5">
    @foreach($cards as $card)
    <div class="col-md-4">
        <div class="card feature-card">
            <div class="feature-icon">
                <i class="{{ $card['icon'] }}"></i>
            </div>
            <div class="feature-title">{{ $card['title'] }}</div>
            <div class="feature-divider"></div>
            <p class="feature-text">{{ $card['text'] }}<br /></p>
        </div>
    </div>
    @endforeach
</div>