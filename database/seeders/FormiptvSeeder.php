<?php

namespace Database\Seeders;

use App\Models\Formiptv;
use Illuminate\Database\Seeder;

class FormiptvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Formiptv::factory()
            ->count(5)
            ->create();
    }
}
