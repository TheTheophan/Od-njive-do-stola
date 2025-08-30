<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\BiljkaPoljoprivrednika;
use Illuminate\Database\Eloquent\Factories\Factory;

class BiljkaPoljoprivrednikaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BiljkaPoljoprivrednika::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'biljkaID' => \App\Models\Biljka::factory(),
            'poljoprivrednikID' => \App\Models\Poljoprivrednik::factory(),
        ];
    }
}
