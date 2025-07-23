<?php

namespace Database\Seeders;

use App\Models\Vod;
use Illuminate\Database\Seeder;

class VodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vod::factory()
            ->count(5)
            ->create();
    }
}
