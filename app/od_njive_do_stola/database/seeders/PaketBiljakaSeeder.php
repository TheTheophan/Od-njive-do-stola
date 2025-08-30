<?php

namespace Database\Seeders;

use App\Models\PaketBiljaka;
use Illuminate\Database\Seeder;

class PaketBiljakaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaketBiljaka::factory()
            ->count(5)
            ->create();
    }
}
