<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\PaketKorisnika;

use App\Models\TipPaketa;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaketKorisnikaTest extends TestCase
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
    public function it_gets_paket_korisnikas_list(): void
    {
        $paketKorisnikas = PaketKorisnika::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.paket-korisnikas.index'));

        $response->assertOk()->assertSee($paketKorisnikas[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_paket_korisnika(): void
    {
        $data = PaketKorisnika::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.paket-korisnikas.store'), $data);

        $this->assertDatabaseHas('paket_korisnikas', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_paket_korisnika(): void
    {
        $paketKorisnika = PaketKorisnika::factory()->create();

        $user = User::factory()->create();
        $tipPaketa = TipPaketa::factory()->create();

        $data = [
            'userID' => $user->id,
            'tipPaketaID' => $tipPaketa->id,
        ];

        $response = $this->putJson(
            route('api.paket-korisnikas.update', $paketKorisnika),
            $data
        );

        $data['id'] = $paketKorisnika->id;

        $this->assertDatabaseHas('paket_korisnikas', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_paket_korisnika(): void
    {
        $paketKorisnika = PaketKorisnika::factory()->create();

        $response = $this->deleteJson(
            route('api.paket-korisnikas.destroy', $paketKorisnika)
        );

        $this->assertModelMissing($paketKorisnika);

        $response->assertNoContent();
    }
}
