<!-- Pricing Plans -->
<div class="row justify-content-center mt-5">
        @foreach($pricingPlans as $plan)
        <div class="col-md-4 mb-4">
            <div class="card text-center shadow-sm border-0" style="border-radius: 10px;">
                <div class="card-body py-5" style="{{ $plan['style'] }} border-radius: 10px;">
                    <div class="icon-circle text-white mx-auto mb-3">
                        <i class="fa fa-tv fa-2x"></i>
                    </div>
                    <h5 class="card-title fw-bold fs-3">{{ $plan['name'] }}</h5>
                    <p class="text-primary fw-bold fs-4">{{ $plan['duration'] }}</p>
                    <h2 class="display-4 fw-bold">{{ $plan['price'] }}</h2>
                    <hr />
                    <ul class="list-unstyled text-start my-4">
                        @foreach($plan['features'] as $feature)
                        <li>
                            {{ $feature }}
                            <i class="fa fa-check text-success float-end"></i>
                        </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('abonnement') }}" class="btn btn-dark w-100 py-2">
                        <i class="fa fa-shopping-cart"></i> Commander
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>