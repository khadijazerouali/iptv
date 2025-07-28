<div>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">

            <a class="navbar-brand ps-5" href="{{ url('/') }}"><img src="{{ asset('/assets/images/Logo.png') }}"
              style="height: 45px" alt="" /></a>
            <div class="container">
                <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                
                <a href="{{ route('abonnement') }}" class="button" style="text-decoration: none;">
    Commander Maintenant
                    <svg fill="currentColor" viewBox="0 0 24 24" class="icon">
                        <path clip-rule="evenodd"
                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm4.28 10.28a.75.75 0 000-1.06l-3-3a.75.75 0 10-1.06 1.06l1.72 1.72H8.25a.75.75 0 000 1.5h5.69l-1.72 1.72a.75.75 0 101.06 1.06l3-3z"
                            fill-rule="evenodd"></path>
                    </svg>
                </a>

                    
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item me-3">
                            <a class="nav-link active text-light fw-bold" aria-current="page" href="{{ route('boutique.index') }}"> BOUTIQUE</a>
                        </li>
                        <li class="nav-item me-3">
                            <a class="nav-link text-light fw-bold"  href="{{ route('testiptv') }}">TEST IPTV</a>
                        </li>
                        <li class="nav-item me-3">
                            <a class="nav-link text-light fw-bold" href="{{ route('chaines-vods') }}">CHIAINES & VODS</a>
                        </li>
                        <li class="nav-item dropdown me-3">
                            <a class="nav-link dropdown-toggle text-light fw-bold nav-assistance" href="{{ route('assistance') }}" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                ASSISTANCE
                            </a>
                            <ul class="dropdown-menu">
                                @auth
                                    @if (Auth::user()->isSuperAdmin())
                                        <li>
                                            <a class="dropdown-item fw-semibold" href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                                        </li>
                                    @else
                                        <li>
                                            <a class="dropdown-item fw-semibold" href="{{ route('dashboard') }}">Mon Profil</a>
                                        </li>
                                    @endif
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item fw-semibold text-danger">Déconnexion</button>
                                        </form>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                @endauth
                                <li>
                                    <a class="dropdown-item fw-semibold"  href="{{ route('Moncompte') }}">Mon Compte</a>
                                </li>
                                <li>
                                    <a class="dropdown-item fw-semibold" href="{{ route('Renouvellement') }}">Renouvellement</a>
                                </li>
                                <li>
                                    <a class="dropdown-item fw-semibold" href="{{ route('Contactez-nous') }}">Contactez-nous</a>
                                </li>
                                <li>
                                    <a class="dropdown-item fw-semibold" href="{{ route('Tutoriel') }}">Tutoriel</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    
                    <!-- Icône du panier avec indicateur -->
                    <div class="cart-icon-container position-relative">
                        <a href="#" wire:click.prevent="toggleCartModal" class="cart-icon-link">
                            <i class="fa-solid fa-cart-shopping" style="color: #ffffff; font-size: 1.2rem;"></i>
                            @if($cart)
                                <span class="cart-badge">{{ $cartDetails['quantity'] ?? 1 }}</span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <style>
        .cart-icon-container {
            position: relative;
            display: inline-block;
        }
        
        .cart-icon-link {
            text-decoration: none;
            position: relative;
            display: inline-block;
        }
        
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
    </style>
</div>