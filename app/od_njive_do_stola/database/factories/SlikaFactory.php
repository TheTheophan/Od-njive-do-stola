<?php

namespace Database\Factories;

use App\Models\Slika;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SlikaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Slika::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'poljoprivrednikID' => \App\Models\Poljoprivrednik::factory(),
        ];
    }
}
