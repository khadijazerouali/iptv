<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('languages')->delete();
        
        DB::table('languages')->insert(array (
            0 => 
            array (
                'uuid' => '01960c1d-81c4-73e6-ae7d-b8732cfc7076',
                'name' => 'Français',
                'code' => 'fr',
                'image' => NULL,
                'image_url' => NULL,
                'created_at' => '2025-04-06 17:19:42',
                'updated_at' => '2025-04-06 17:19:42',
            ),
        ));
        
        
    }
}