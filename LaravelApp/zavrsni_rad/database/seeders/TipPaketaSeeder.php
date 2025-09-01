<?php

namespace Database\Seeders;

use App\Models\TipPaketa;
use Illuminate\Database\Seeder;

class TipPaketaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipPaketa::factory()
            ->count(5)
            ->create();
    }
}
