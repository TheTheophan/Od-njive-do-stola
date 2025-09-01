<?php

namespace Database\Seeders;

use App\Models\Faktura;
use Illuminate\Database\Seeder;

class FakturaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Faktura::factory()
            ->count(5)
            ->create();
    }
}
