<?php

namespace Database\Seeders;

use App\Models\Slika;
use Illuminate\Database\Seeder;

class SlikaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Slika::factory()
            ->count(5)
            ->create();
    }
}
