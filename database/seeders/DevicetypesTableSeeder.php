<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DevicetypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('devicetypes')->delete();
        
        DB::table('devicetypes')->insert(array (
            0 => 
            array (
                'uuid' => '01960c1d-8203-7151-a7dc-aaac974250fe',
            'name' => 'Android ( TV Box / smartphone )',
                'macaddress' => 0,
                'magaddress' => 0,
                'formulermac' => 0,
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            1 => 
            array (
                'uuid' => '01960c1d-8204-728b-ba7b-ac58355c0760',
                'name' => 'Smart TV',
                'macaddress' => 0,
                'magaddress' => 0,
                'formulermac' => 0,
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            2 => 
            array (
                'uuid' => '01960c1d-8205-70e4-a3d7-96582b093846',
                'name' => 'Smart TV Android',
                'macaddress' => 0,
                'magaddress' => 0,
                'formulermac' => 0,
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            3 => 
            array (
                'uuid' => '01960c1d-8206-709d-911f-29f3d9c20539',
                'name' => 'Lien m3u / m3u plus',
                'macaddress' => 0,
                'magaddress' => 0,
                'formulermac' => 0,
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            4 => 
            array (
                'uuid' => '01960c1d-8207-703a-a1be-b484661d6f06',
                'name' => 'Formuler',
                'macaddress' => 0,
                'magaddress' => 0,
                'formulermac' => 0,
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            5 => 
            array (
                'uuid' => '01960c1d-8207-703a-a1be-b484664ef47f',
                'name' => 'MAG',
                'macaddress' => 0,
                'magaddress' => 0,
                'formulermac' => 0,
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            6 => 
            array (
                'uuid' => '01960c1d-8208-7210-9a3e-586ef4fdd675',
                'name' => 'Apple TV 4 ou plus',
                'macaddress' => 0,
                'magaddress' => 0,
                'formulermac' => 0,
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
            7 => 
            array (
                'uuid' => '01960c1d-8209-73bd-ae3d-f5fd2bd854d0',
            'name' => 'Apple (iphone/iPad)',
                'macaddress' => 0,
                'magaddress' => 0,
                'formulermac' => 0,
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
        ));
        
        
    }
}