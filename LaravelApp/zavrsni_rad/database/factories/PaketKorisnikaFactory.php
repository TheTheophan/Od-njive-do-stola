<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\PaketKorisnika;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaketKorisnikaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PaketKorisnika::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uputstvo_za_dostavu' => $this->faker->text(254),
            'tip_paketa_id' => \App\Models\TipPaketa::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
