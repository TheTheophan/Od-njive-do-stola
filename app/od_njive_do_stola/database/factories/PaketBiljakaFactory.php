<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\PaketBiljaka;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaketBiljakaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PaketBiljaka::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'biljkaPoljoprivrednikaID' => \App\Models\BiljkaPoljoprivrednika::factory(),
            'paketKorisnikaID' => \App\Models\PaketKorisnika::factory(),
        ];
    }
}
