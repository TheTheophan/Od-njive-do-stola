<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\PaketKorisnika;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserPaketKorisnikasTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_user_paket_korisnikas(): void
    {
        $user = User::factory()->create();
        $paketKorisnikas = PaketKorisnika::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.paket-korisnikas.index', $user)
        );

        $response->assertOk()->assertSee($paketKorisnikas[0]->adresa);
    }

    /**
     * @test
     */
    public function it_stores_the_user_paket_korisnikas(): void
    {
        $user = User::factory()->create();
        $data = PaketKorisnika::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.paket-korisnikas.store', $user),
            $data
        );

        $this->assertDatabaseHas('paket_korisnikas', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $paketKorisnika = PaketKorisnika::latest('id')->first();

        $this->assertEquals($user->id, $paketKorisnika->user_id);
    }
}
