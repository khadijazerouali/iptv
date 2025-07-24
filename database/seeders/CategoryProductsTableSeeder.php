<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryProductsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('category_products')->delete();
        
        DB::table('category_products')->insert(array (
            0 => 
            array (
                'uuid' => '019641b5-33a1-7230-ba2f-9d7aa3e3dddc',
                'name' => 'Abonnements',
                'slug' => 'abonnements',
                'description' => 'abonnements',
                'icon_url' => NULL,
                'created_at' => '2025-04-17 03:05:16',
                'updated_at' => '2025-04-17 03:05:16',
            ),
            1 => 
            array (
                'uuid' => '01964de2-ebf9-7140-b182-baf94bf991f8',
                'name' => 'Test IPTV',
                'slug' => 'test-iptv',
                'description' => 'test iptv',
                'icon_url' => NULL,
                'created_at' => '2025-04-19 11:50:39',
                'updated_at' => '2025-04-19 11:50:55',
            ),
            2 => 
            array (
                'uuid' => '01964e00-0965-7217-ab75-34fb3370d652',
                'name' => 'revendeur',
                'slug' => 'revendeur',
                'description' => 'revendeur',
                'icon_url' => NULL,
                'created_at' => '2025-04-19 12:22:27',
                'updated_at' => '2025-04-19 12:22:27',
            ),
            3 => 
            array (
                'uuid' => '01964e00-3556-723a-a6b6-5d641dfc9177',
                'name' => 'Renouvellement',
                'slug' => 'renouvellement',
                'description' => 'renouvellement',
                'icon_url' => NULL,
                'created_at' => '2025-04-19 12:22:38',
                'updated_at' => '2025-04-19 14:38:37',
            ),
            4 => 
            array (
                'uuid' => '01964e00-8b63-7218-8d37-87ee46d7966f',
                'name' => 'Application',
                'slug' => 'application',
                'description' => 'Application',
                'icon_url' => NULL,
                'created_at' => '2025-04-19 12:23:00',
                'updated_at' => '2025-04-19 12:23:00',
            ),
        ));
        
        
    }
}