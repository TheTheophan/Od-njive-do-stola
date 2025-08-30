<?php

namespace Database\Seeders;

use App\Models\PaketKorisnika;
use Illuminate\Database\Seeder;

class PaketKorisnikaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaketKorisnika::factory()
            ->count(5)
            ->create();
    }
}
