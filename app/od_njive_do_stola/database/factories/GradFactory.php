<?php

namespace Database\Factories;

use App\Models\Grad;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class GradFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Grad::class;

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
