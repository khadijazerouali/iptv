<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('products')->delete();
        
        DB::table('products')->insert(array (
            0 => 
            array (
                'uuid' => '019641b7-5fd5-7092-93be-01b146ef484c',
                'category_uuid' => '019641b5-33a1-7230-ba2f-9d7aa3e3dddc',
                
                'title' => 'Abonnement IPTV Premium | Smart TV , MAG , Formuler , Android , iOS Apple TV , PC',
                'slug' => 'abonnement-iptv-premium-smart-tv-mag-formuler-android-ios-apple-tv-pc',
                'price_old' => 19,
                'price' => 9,
            'description' => '<p>Grâce à plusieurs années d’expérience dans le domaine de l’iptv nous avons acquis tous les compétence nécessaire afin de vous offrir un service de qualité supérieurs, nous étions tout au long des années proches de nos clients, cela afin d’offrir une meilleure expérience possible malgré plusieurs contraintes connus, notre abonnement IPTV regroupe les chaines du monde entier ainsi que des vidéos à la demande de toutes les langues, vous pouvez regarder toutes vos chaine TV favorites peu importe votre nationalité et votre pays de résidence.</p><p>Notre abonnement IPTV contient aussi les vidéo à la demande en multilingues avec une qualité en FHD et sous titrages en option, notre playlist m3u est mise à jour régulièrement par une équipe spécialisée dédiée ainsi qu’une assistance client 7/7 !</p><p><strong>Compatible avec tous les dispositifs et appareils :</strong></p><p>Notre Abonnement iptv premium est compatible avec une variété d’appareils , y compris les téléviseurs intelligents, les lecteurs multimédias en continu (tels que Roku, Apple TV et Amazon Fire TV), les ordinateurs, les smartphones, les tablettes et les consoles de jeux.</p><p><strong>Un large choix d’application IPTV est disponible et compatibles avec notre abonnement :</strong> Duplex Play, Smart IPTV, IPTV Extreme, PremiumPlay, Net IPTV, Set IPTV, Bay IPTV, Smartone player, IBO player, Room IPTV,&nbsp; Kodi player, Xtream codes Player, IPTV Smarters, XCiptv, Stb Emu, Smart STB, Gse Smart IPTV, Iplay tv …etc</p>',
                'status' => 'active',
                'image' => '01JS0VEQYDC3PSVM714WZ925BJ.png',
                'type' => 'abonnement',
                'view' => NULL,
                'created_at' => '2025-04-17 03:07:38',
                'updated_at' => '2025-04-17 03:07:38',
            ),
            1 => 
            array (
                'uuid' => '01964de5-3e34-7037-8805-10f9c8e2fb40',
                'category_uuid' => '01964de2-ebf9-7140-b182-baf94bf991f8',
                
                'title' => 'Premium IPTV – Test 24h',
                'slug' => 'premium-iptv-test-24h',
                'price_old' => 5,
                'price' => 3,
            'description' => '<p><strong>Appareils disponible Avec Notre server :</strong> Smart TV ( tous les marques ) , TV Box Android , <a href="https://www.infomir.eu/fra/">Mag</a> ( tous les types ) , Formulaires Z/Z+/Z8 , Apple ( iphone , ipad ) , Apple TV , Smartphone Android , Enigma , PC ……</p><p><strong>Bouquets disponibles dans notre </strong><a href="https://abonnement-iptvpremium.com"><strong>Test IPTV</strong></a><strong> (par Pays) :</strong> France , Belgique, Suisse, Hollande, Autriche, Espagne, Portugal, Italie, Allemagne, Turquie, Roumanie, Ex yu, Serbie, Croatie, Grec, Arminien, Bosnie, Czech, Albanie, Russie , Arabe (Maroc, Algérie, Tunisie, Égypte, Iraq, Serie, UAE, Lebanon, Kuwait, Yemen, Soudan, Jordanie, palestine, Libye, Saudi Arabite) , UK , Latino, USA, Canada, Afrique, Somalie, Inde, Pakistan, kurde, Afghanistan, Azerbaïdjan, ..</p><p><strong>Vidéo à la demande par pays (langue audio et sous titrage) :</strong> Français, Anglais , Hollandais, Arabes, Italien, Portugais , Grec, Turquie, Allemand, Italien, Espagnol, Polonais, Somalie .</p><p><strong>NB:</strong> <em>Pour toute demande d’ajout de nouveaux films ou de séries, vous pouvez demander à notre support de les ajouter à tout moment, nous les ajouterons sous 2-3 jours !</em></p><p>Nous vous garantissons un <a href="https://abonnement-iptvpremium.com/produit/test-iptv-premium/"><strong>Test IPTV</strong></a> de très haute qualité . Une qualité d’image fluide exceptionnelle quelque soit en HD ou FHD/Ultra HD HEVC et 4K .&nbsp; Serveur de haut gamme et un service de qualité supérieur , chaines classées par Pays et par qualité /résolution d’image (SD/HD – HEVC et FHD /4k ).</p><p>Un grand débit n’est plus nécessaire pour regarder en toute fluidité, un débit de 12Mbps suffit, si vous avez un plus bas débit , nous avons des bouquets IPTV en qualité SD .</p><h3><strong>Si vous n’êtes pas satisfait dans un délai de 48h , assurez-vous que vous aurez votre remboursement immédiatement.</strong></h3>',
                'status' => 'active',
                'image' => '01JS6YAFH9XNPZ2CY82WKWRV7B.png',
                'type' => 'testiptv',
                'view' => NULL,
                'created_at' => '2025-04-19 11:53:11',
                'updated_at' => '2025-04-19 11:53:11',
            ),
            2 => 
            array (
                'uuid' => '01964e08-20ed-70d5-aad4-adcddcc5e4c8',
                'category_uuid' => '01964e00-0965-7217-ab75-34fb3370d652',
                
                'title' => 'Devenir notre Revendeur IPTV – 4k Premium IPTV',
                'slug' => 'devenir-notre-revendeur-iptv-4k-premium-iptv',
                'price_old' => 550,
                'price' => 180,
            'description' => '<h2>Devenir notre Revendeur IPTV</h2><p>Découvrez le moyen facile de gagner de l’argent en devenant un revendeur Avec 4k Premium IPTV :<br><br></p><p>Savez-vous que plus de 50 millions de personnes dans le monde utilisent les services IPTV ? Démarrez votre propre entreprise IPTV maintenant et gagnez plus de 10 000 € par mois. Vous n’avez besoin que de votre propre interface IPTV pour démarrer .</p><p>c’est très simple , Vous devez simplement <a href="https://abonnement-iptvpremium.com/produit/revendeur-iptv-premium/">s’abonner</a> pour un compte revendeur, puis annoncer notre service à vos voisins, votre famille, vos utilisateurs, où vous pouvez générer des lignes pour les utilisateurs.</p><h3><strong>Comment fonctionne le Panel IPTV et le compte revendeur ?</strong></h3><p>Le compte revendeur n’est pas basé sur le temps, ce qui signifie que si vous achetez un compte revendeur, il n’expirera pas du tout ! La seule chose importante est vos crédits. Les crédits vous permettent de créer des comptes pour les utilisateurs. Par exemple, la création d’un compte d’un mois vous coûte 1 crédit. Vous pouvez vendre notre service tant qu’il vous reste des crédits. Si vous n’avez plus de crédits, vous pouvez en ajouter en passant une nouvelle commande.</p><ul><li>NOTE : Si le compte revendeur est inactif pendant plus de 3 mois, il sera désactivé.</li></ul><h3><strong>Explication de notre offre revendeur :</strong></h3><p>La revente de nos <a href="https://abonnement-iptvpremium.com">abonnements IPTV</a> se fait via une interface (<em>panel</em>) de gestion clients, ce panel est accessible via un lien <em>(qui peu être utilisé depuis n’importe quel navigateur web)</em>, l’interface est protégé par Identifiant + Mot de passe <em>(uniques pour chaque revendeur). Devenir notre Revendeur IPTV<br></em><br></p><p>Le panel fonctionne avec un portefeuille de crédits, chaque abonnement de 12mois créé consomme 1 crédit :</p><p><strong>12mois</strong> <strong>=</strong> <strong>1 credit</strong></p><p><strong>6 mois = 0.6 credit</strong></p><p><strong>3 mois = 0.3 credit</strong></p><p><strong>1 mois = 0.1 credit</strong></p><p><em>Les tests gratuits ne sont pas disponible pour le moment .<br></em><br></p><p><strong>Important : </strong><strong><em>il est strictement interdit de vendre sur internet et sur les plateforme en ligne comme Ebay ou place de marchés en ligne sous notre nom , si nous découvrons cela votre compte revendeur sera bloqué et toute demande de remboursement sera refusée .</em></strong></p><p><br></p>',
                'status' => 'active',
                'image' => '01JS70G876Z9NCMHK4M44TKXN7.png',
                'type' => 'revendeur',
                'view' => NULL,
                'created_at' => '2025-04-19 12:31:17',
                'updated_at' => '2025-04-19 12:31:17',
            ),
            3 => 
            array (
                'uuid' => '0196503a-5172-7312-b974-7c38ec006315',
                'category_uuid' => '01964e00-3556-723a-a6b6-5d641dfc9177',
                
                'title' => 'Renouvellement d’abonnement',
                'slug' => 'renouvellement-dabonnement',
                'price_old' => 67,
                'price' => 59,
                'description' => NULL,
                'status' => 'active',
                'image' => '01JS83MMB4XWARC5N7GWJ6KVXX.png',
                'type' => 'renouvellement',
                'view' => NULL,
                'created_at' => '2025-04-19 22:45:21',
                'updated_at' => '2025-04-19 22:45:21',
            ),
        ));
        
        
    }
}