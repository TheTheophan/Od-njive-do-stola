<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Faktura;

use App\Models\PaketKorisnika;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FakturaTest extends TestCase
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
    public function it_gets_fakturas_list(): void
    {
        $fakturas = Faktura::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.fakturas.index'));

        $response->assertOk()->assertSee($fakturas[0]->tekst);
    }

    /**
     * @test
     */
    public function it_stores_the_faktura(): void
    {
        $data = Faktura::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.fakturas.store'), $data);

        $this->assertDatabaseHas('fakturas', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_faktura(): void
    {
        $faktura = Faktura::factory()->create();

        $paketKorisnika = PaketKorisnika::factory()->create();

        $data = [
            'paket_korisnika_id' => $paketKorisnika->id,
        ];

        $response = $this->putJson(
            route('api.fakturas.update', $faktura),
            $data
        );

        $data['id'] = $faktura->id;

        $this->assertDatabaseHas('fakturas', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_faktura(): void
    {
        $faktura = Faktura::factory()->create();

        $response = $this->deleteJson(route('api.fakturas.destroy', $faktura));

        $this->assertModelMissing($faktura);

        $response->assertNoContent();
    }
}
