<?php

namespace Database\Seeders;

use App\Models\TicketReplie;
use Illuminate\Database\Seeder;

class TicketReplieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TicketReplie::factory()
            ->count(5)
            ->create();
    }
}
