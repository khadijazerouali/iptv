<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChannelsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('channels')->delete();
        
        DB::table('channels')->insert(array (
            0 => 
            array (
                'uuid' => '01960c1d-81e3-70e3-a489-92ce0cb1f240',
                'title' => 'France',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            1 => 
            array (
                'uuid' => '01960c1d-81e4-7150-a26f-32c099985a93',
                'title' => 'Belgique',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            2 => 
            array (
                'uuid' => '01960c1d-81e5-72cc-afa2-45a47a76c0ef',
                'title' => 'Portugal',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            3 => 
            array (
                'uuid' => '01960c1d-81e6-718c-8ee0-782becafdbf5',
                'title' => 'Espagne',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            4 => 
            array (
                'uuid' => '01960c1d-81e7-72dc-af2a-ee7e23fccd1c',
                'title' => 'United Kingdom',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            5 => 
            array (
                'uuid' => '01960c1d-81e8-712a-a9bc-7c0415d01c9e',
                'title' => 'Italie',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            6 => 
            array (
                'uuid' => '01960c1d-81e9-7298-872b-015b5d3c6b78',
                'title' => 'Hollande',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            7 => 
            array (
                'uuid' => '01960c1d-81ea-7293-b73c-1dadbbc026fa',
                'title' => 'Allemagne',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            8 => 
            array (
                'uuid' => '01960c1d-81eb-7036-accf-d40c625ec54d',
                'title' => 'Arabe',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            9 => 
            array (
                'uuid' => '01960c1d-81ec-7227-9ccd-b2ff387378f3',
                'title' => 'Afrique',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            10 => 
            array (
                'uuid' => '01960c1d-81ed-7025-b1bd-1b11004e4cd2',
                'title' => 'Usa',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            11 => 
            array (
                'uuid' => '01960c1d-81ed-7025-b1bd-1b1101004aff',
                'title' => 'Canada',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            12 => 
            array (
                'uuid' => '01960c1d-81ee-7179-83fd-a76aa82ff32b',
                'title' => 'Autriche',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            13 => 
            array (
                'uuid' => '01960c1d-81f0-7133-98d6-65bad132dc23',
                'title' => 'EX yu',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            14 => 
            array (
                'uuid' => '01960c1d-81f1-7384-bacd-5cdce0bc612a',
                'title' => 'Czech',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            15 => 
            array (
                'uuid' => '01960c1d-81f2-7278-bb20-5c54e5c9426a',
                'title' => 'Turquie',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            16 => 
            array (
                'uuid' => '01960c1d-81f3-726f-9daa-4a9e8f027a55',
                'title' => 'Suède',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            17 => 
            array (
                'uuid' => '01960c1d-81f4-702d-92e2-0e3e25599758',
                'title' => 'Danemark',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            18 => 
            array (
                'uuid' => '01960c1d-81f5-7047-ad0a-afe76e27a5c3',
                'title' => 'Norvège',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            19 => 
            array (
                'uuid' => '01960c1d-81f5-7047-ad0a-afe76e676d96',
                'title' => 'Finlande',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            20 => 
            array (
                'uuid' => '01960c1d-81f6-72aa-ba3f-973630cd899b',
                'title' => 'Russie',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            21 => 
            array (
                'uuid' => '01960c1d-81f7-73bd-8437-a1549e3c9298',
                'title' => 'Ukraine',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            22 => 
            array (
                'uuid' => '01960c1d-81f8-725a-b477-3d6752794926',
                'title' => 'Roumanie',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            23 => 
            array (
                'uuid' => '01960c1d-81f9-7223-93a9-71a3cebd44fa',
                'title' => 'Serbie',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            24 => 
            array (
                'uuid' => '01960c1d-81fb-7012-a0b6-038a3dfb9114',
                'title' => 'Croatie',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            25 => 
            array (
                'uuid' => '01960c1d-81fb-7012-a0b6-038a3eadd7ce',
                'title' => 'Grec',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            26 => 
            array (
                'uuid' => '01960c1d-81fc-7360-b02f-472518a595bb',
                'title' => 'Arminien',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            27 => 
            array (
                'uuid' => '01960c1d-81fd-7001-894c-067ecbfcff04',
                'title' => 'Bulgarie',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            28 => 
            array (
                'uuid' => '01960c1d-81fe-7290-8def-335a0975ef78',
                'title' => 'Pologne',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            29 => 
            array (
                'uuid' => '01960c1d-81ff-7070-aa34-8330fdf9d3a4',
                'title' => 'Albanie',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            30 => 
            array (
                'uuid' => '01960c1d-8200-7210-8250-46b3bd56b580',
                'title' => 'Latino',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            31 => 
            array (
                'uuid' => '01960c1d-8201-73cd-bdd3-0d3e55d6c5b5',
                'title' => 'Brazil',
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
        ));
        
        
    }
}