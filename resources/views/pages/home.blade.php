@extends('layouts.main')

@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-12 mt-4">
                <h2 class="text-center fw-bold title">
                    <img role="img" class="emojiball" alt=""
                        src="https://s.w.org/images/core/emoji/15.0.3/svg/26bd.svg" />
                    Les meilleurs Abonnements iptv en France et en Europe​
                    <img role="img" class="emojiball" style="margin-left: 10px;" alt=""
                        src="https://s.w.org/images/core/emoji/15.0.3/svg/26bd.svg" />
                </h2>
            </div>
            <div class="row mt-5">
                <div class="col-md-6">
                    <p class="lh-lg">
                        <strong>Abonnement iptvpremium </strong> est le fournisseur le
                        plus connus dans le marché d’IPTV , nous offrons les meilleur
                        <strong>abonnements IPTV</strong> de haute qualité et garanti sans
                        coupure avec 10 ans d’expérience. Nos abonnements IPTV à le
                        meilleur prix au marche de l’IPTV en Europe et dans le monde
                        entier .
                    </p>
                    <br />
                    <p class="lh-lg">
                        La liste de chaines de notre <strong>Code IPTV</strong> et
                        disposent d’une playlist de plus de 69,000 chaines francophones et
                        Internationaux en 4K/FHD/HD/SD , et un Catalogue de Vods très
                        riche , avec la dernière mise à jour 2023 / 2024 de films et
                        séries à la demande .
                    </p>
                </div>
                <div class="col-md-6">
                    <img src="/assets/images/Monitors.png" width="700" alt="Monitors" />
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <h2 class="text-center fw-bold">
                    DÉCOUVREZ LES PACK DE NOS ABONNEMENTS IPTV.
                </h2>
            </div>
        </div>

        <!-- Packs Section -->
        <livewire:widget.packhomepage />

        <!-- Slider -->
        <livewire:widget.supportdevice />


        <!-- Cards-->
        <livewire:widget.card-info />

        <!--Nos produis-->
        <div class="row my-5">
            <div class="col-md-12">
                <h2 class="extra-bold text-center">Nos Produit<span class="text-primary">.</span></h2>
            </div>
        </div>


    </div>
   
    <livewire:widget.nos-product />
    
@endsection