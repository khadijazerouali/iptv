<?php

namespace Database\Seeders;

use App\Models\FormRevendeur;
use Illuminate\Database\Seeder;

class FormRevendeurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FormRevendeur::factory()
            ->count(5)
            ->create();
    }
}
