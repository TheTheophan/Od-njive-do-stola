<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Faktura;
use App\Models\PaketKorisnika;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaketKorisnikaFakturasTest extends TestCase
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
    public function it_gets_paket_korisnika_fakturas(): void
    {
        $paketKorisnika = PaketKorisnika::factory()->create();
        $fakturas = Faktura::factory()
            ->count(2)
            ->create([
                'paket_korisnika_id' => $paketKorisnika->id,
            ]);

        $response = $this->getJson(
            route('api.paket-korisnikas.fakturas.index', $paketKorisnika)
        );

        $response->assertOk()->assertSee($fakturas[0]->tekst);
    }

    /**
     * @test
     */
    public function it_stores_the_paket_korisnika_fakturas(): void
    {
        $paketKorisnika = PaketKorisnika::factory()->create();
        $data = Faktura::factory()
            ->make([
                'paket_korisnika_id' => $paketKorisnika->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.paket-korisnikas.fakturas.store', $paketKorisnika),
            $data
        );

        $this->assertDatabaseHas('fakturas', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $faktura = Faktura::latest('id')->first();

        $this->assertEquals($paketKorisnika->id, $faktura->paket_korisnika_id);
    }
}
