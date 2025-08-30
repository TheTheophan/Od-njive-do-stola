<?php

namespace Database\Factories;

use App\Models\Biljka;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class BiljkaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Biljka::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [];
    }
}
