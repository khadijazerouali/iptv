<?php

namespace Database\Seeders;

use App\Models\Vod;
use App\Models\User;
use App\Models\Channel;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use App\Models\Devicetype;
use App\Helpers\SlugHelper;
use App\Models\Applicationtype;
use App\Models\CategoryProduct;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public function run(): void
    {
        // Création d'un super-admin par défaut
        $admin = \App\Models\User::firstOrCreate(
            [
                'email' => 'admin@admin.com',
            ],
            [
                'name' => 'Admin',
                'password' => bcrypt('motdepassefort'),
            ]
        );
        if (\Spatie\Permission\Models\Role::where('name', 'super-admin')->exists()) {
            $admin->assignRole('super-admin');
        }
        $this->call(PermissionsSeeder::class);

        // $language_fr = \App\Models\Language::create([
        //     'name' => 'Français',
        //     'code' => 'fr',
        // ]);

        // $vodOptions = [
        //     'Vods Français', 'Vods Anglais', 'Vods Arabe', 'Vods Hollandais', 'Vods Allemand',
        //     'Vods Spain', 'Vods Italy', 'Vods Turquie', 'Vos Bollywood', 'Vods Somalie',
        //     'Vods Russia', 'Vods Sweden', 'Vods Norway', 'Vods Danmark', 'Vods Finland',
        //     'Vods Iran', 'Vods Exyu', 'Vods Greece', 'Vods Poland', 'Vods Portugal-Brazil',
        //     'Vods Scandinavia', 'Vods Czech Republic', 'Vods Albanie', 'Vods Philippine',
        //     'Vods Israel', 'Vods Bulgarie', 'Vods Malta',
        //     ];
        // foreach ($vodOptions as $vod) {
        //     Vod::create([
        //         'title' => $vod,
        //         
        //     ]);
        $this->call(LanguagesTableSeeder::class);
        $this->call(CategoryProductsTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(VodsTableSeeder::class);
        $this->call(ChannelsTableSeeder::class);
        $this->call(DevicetypesTableSeeder::class);
        $this->call(ApplicationtypesTableSeeder::class);
        $this->call(SupportCategorySeeder::class);
      
        
        $this->call(ProductOptionsTableSeeder::class);
    }

        // $channelList = [
        //     'France', 'Belgique', 'Portugal', 'Espagne', 'United Kingdom', 'Italie', 'Hollande',
        //     'Allemagne', 'Arabe', 'Afrique', 'Usa', 'Canada', 'Autriche', 'EX yu', 'Czech', 'Turquie',
        //     'Suède', 'Danemark', 'Norvège', 'Finlande', 'Russie', 'Ukraine', 'Roumanie', 'Serbie',
        //     'Croatie', 'Grec', 'Arminien', 'Bulgarie', 'Pologne', 'Albanie', 'Latino', 'Brazil'
        // ];
        // foreach ($channelList as $channel) {
        //     Channel::create([
        //         'title' => $channel,
        //         
        //     ]);
        // }

        // $deviceList = [
        //     'Android ( TV Box / smartphone )', 'Smart TV', 'Smart TV Android', 'Lien m3u / m3u plus', 'Formuler', 'MAG', 'Apple TV 4 ou plus', 'Apple (iphone/iPad)'
        // ];
        // foreach ($deviceList as $device) {
        //     Devicetype::create([
        //         'name' => $device,
        //         
        //     ]);
        // }

        // $devicetypes = Devicetype::all();
        // $applicationList = [
        //     'IPTV Smarters pro', 'TiviMate iptv player', 'Duplex Play', 'Xciptv Player', 'ibo player', 'IPTV Extreme pro', 'Gse smart iptv', 'Nanomid Player'
        // ];
        // foreach ($applicationList as $application) {
        //     Applicationtype::create([
        //         'name' => $application,
        //         'devicetype_uuid' => $devicetypes->random()->uuid,
        //         
        //     ]);
        // }
        
    // }
}
