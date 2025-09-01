<?php

namespace Database\Factories;

use App\Models\Faktura;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class FakturaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Faktura::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'paket_korisnika_id' => \App\Models\PaketKorisnika::factory(),
        ];
    }
}
