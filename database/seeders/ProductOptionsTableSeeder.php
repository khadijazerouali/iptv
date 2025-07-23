<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductOptionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('product_options')->delete();
        
        DB::table('product_options')->insert(array (
            0 => 
            array (
                'uuid' => '019641b8-bb0f-70d6-8abc-0e982c456afa',
                'product_uuid' => '019641b7-5fd5-7092-93be-01b146ef484c',
                'name' => '1 mois',
                'price' => 5,
                'created_at' => '2025-04-17 03:09:07',
                'updated_at' => '2025-04-17 03:09:07',
            ),
            1 => 
            array (
                'uuid' => '019641b8-bb12-7176-9a70-65db5356bf3e',
                'product_uuid' => '019641b7-5fd5-7092-93be-01b146ef484c',
                'name' => '3 mois',
                'price' => 13,
                'created_at' => '2025-04-17 03:09:07',
                'updated_at' => '2025-04-17 03:09:07',
            ),
            2 => 
            array (
                'uuid' => '01964e08-20f3-71d2-bf37-b5e66381396d',
                'product_uuid' => '01964e08-20ed-70d5-aad4-adcddcc5e4c8',
                'name' => '5 Point',
                'price' => 180,
                'created_at' => '2025-04-19 12:31:17',
                'updated_at' => '2025-04-19 12:34:15',
            ),
            3 => 
            array (
                'uuid' => '01964e08-20f5-716f-b1d5-fbec97bc75f3',
                'product_uuid' => '01964e08-20ed-70d5-aad4-adcddcc5e4c8',
                'name' => '10',
                'price' => 330,
                'created_at' => '2025-04-19 12:31:17',
                'updated_at' => '2025-04-19 12:34:15',
            ),
            4 => 
            array (
                'uuid' => '01964e08-20f7-7081-a1bc-ec43e1afd237',
                'product_uuid' => '01964e08-20ed-70d5-aad4-adcddcc5e4c8',
                'name' => '15',
                'price' => 550,
                'created_at' => '2025-04-19 12:31:17',
                'updated_at' => '2025-04-19 12:34:15',
            ),
            5 => 
            array (
                'uuid' => '0196503a-517f-73ba-916e-5b17a40d5d77',
                'product_uuid' => '0196503a-5172-7312-b974-7c38ec006315',
                'name' => '1 mois',
                'price' => 12,
                'created_at' => '2025-04-19 22:45:21',
                'updated_at' => '2025-04-19 22:45:21',
            ),
            6 => 
            array (
                'uuid' => '0196503a-5186-70dd-8620-a6abc8ead516',
                'product_uuid' => '0196503a-5172-7312-b974-7c38ec006315',
                'name' => '3 mois',
                'price' => 26,
                'created_at' => '2025-04-19 22:45:21',
                'updated_at' => '2025-04-19 22:45:21',
            ),
            7 => 
            array (
                'uuid' => '0196503a-5189-7233-b241-718b84e4877e',
                'product_uuid' => '0196503a-5172-7312-b974-7c38ec006315',
                'name' => '6 mois',
                'price' => 40,
                'created_at' => '2025-04-19 22:45:21',
                'updated_at' => '2025-04-19 22:45:21',
            ),
            8 => 
            array (
                'uuid' => '0196503a-518e-71b7-9fe2-89e77def89fb',
                'product_uuid' => '0196503a-5172-7312-b974-7c38ec006315',
                'name' => '12 mois',
                'price' => 59,
                'created_at' => '2025-04-19 22:45:21',
                'updated_at' => '2025-04-19 22:45:21',
            ),
        ));
        
        
    }
}