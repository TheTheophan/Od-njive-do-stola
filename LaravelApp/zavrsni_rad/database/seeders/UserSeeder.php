<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Marko Jovanović', 'email' => 'marko.jovanovic@example.com'],
            ['name' => 'Jelena Petrović', 'email' => 'jelena.petrovic@example.com'],
            ['name' => 'Nikola Nikolić', 'email' => 'nikola.nikolic@example.com'],
            ['name' => 'Ana Stojanović', 'email' => 'ana.stojanovic@example.com'],
            ['name' => 'Miloš Ilić', 'email' => 'milos.ilic@example.com'],
            ['name' => 'Ivana Kovačević', 'email' => 'ivana.kovacevic@example.com'],
            ['name' => 'Stefan Savić', 'email' => 'stefan.savic@example.com'],
            ['name' => 'Milica Đorđević', 'email' => 'milica.djordjevic@example.com'],
            ['name' => 'Aleksandar Popović', 'email' => 'aleksandar.popovic@example.com'],
            ['name' => 'Dragana Vuković', 'email' => 'dragana.vukovic@example.com'],
            ['name' => 'Vladimir Pavlović', 'email' => 'vladimir.pavlovic@example.com'],
            ['name' => 'Tamara Lukić', 'email' => 'tamara.lukic@example.com'],
            ['name' => 'Dušan Janković', 'email' => 'dusan.jankovic@example.com'],
            ['name' => 'Sanja Milenković', 'email' => 'sanja.milenkovic@example.com'],
            ['name' => 'Goran Ristić', 'email' => 'goran.ristic@example.com'],
            ['name' => 'Marija Krstić', 'email' => 'marija.krstic@example.com'],
            ['name' => 'Petar Tomić', 'email' => 'petar.tomic@example.com'],
            ['name' => 'Katarina Radovanović', 'email' => 'katarina.radovanovic@example.com'],
            ['name' => 'Nenad Stanković', 'email' => 'nenad.stankovic@example.com'],
            ['name' => 'Jovana Mladenović', 'email' => 'jovana.mladenovic@example.com'],
            ['name' => 'Slobodan Filipović', 'email' => 'slobodan.filipovic@example.com'],
            ['name' => 'Teodora Živković', 'email' => 'teodora.zivkovic@example.com'],
            ['name' => 'Milan Petković', 'email' => 'milan.petkovic@example.com'],
            ['name' => 'Ivana Marković', 'email' => 'ivana.markovic@example.com'],
            ['name' => 'Bojan Jović', 'email' => 'bojan.jovic@example.com'],
            ['name' => 'Sara Ilić', 'email' => 'sara.ilic@example.com'],
            ['name' => 'Vesna Stojanović', 'email' => 'vesna.stojanovic@example.com'],
            ['name' => 'Luka Đorđević', 'email' => 'luka.djordjevic@example.com'],
            ['name' => 'Maja Simić', 'email' => 'maja.simic@example.com'],
            ['name' => 'Radovan Kostić', 'email' => 'radovan.kostic@example.com'],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => bcrypt('adminadmin'),
                'email_verified_at' => now(),
            ]);
        }
    }
}
