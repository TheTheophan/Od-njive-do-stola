<?php

namespace Database\Seeders;

use App\Models\Biljka;
use Illuminate\Database\Seeder;

class BiljkaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Biljka::factory()
            ->count(5)
            ->create();
    }
}
