<?php

namespace Database\Seeders;

use App\Models\Grad;
use Illuminate\Database\Seeder;

class GradSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Grad::factory()
            ->count(5)
            ->create();
    }
}
