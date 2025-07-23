<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormRenouvellement;

class FormRenouvellementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FormRenouvellement::factory()
            ->count(5)
            ->create();
    }
}
