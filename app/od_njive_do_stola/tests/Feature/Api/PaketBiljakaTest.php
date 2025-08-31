<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\PaketBiljaka;

use App\Models\PaketKorisnika;
use App\Models\BiljkaPoljoprivrednika;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaketBiljakaTest extends TestCase
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
    public function it_gets_paket_biljakas_list(): void
    {
        $paketBiljakas = PaketBiljaka::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.paket-biljakas.index'));

        $response->assertOk()->assertSee($paketBiljakas[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_paket_biljaka(): void
    {
        $data = PaketBiljaka::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.paket-biljakas.store'), $data);

        $this->assertDatabaseHas('paket_biljakas', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_paket_biljaka(): void
    {
        $paketBiljaka = PaketBiljaka::factory()->create();

        $biljkaPoljoprivrednika = BiljkaPoljoprivrednika::factory()->create();
        $paketKorisnika = PaketKorisnika::factory()->create();

        $data = [
            'biljkaPoljoprivrednikaID' => $biljkaPoljoprivrednika->id,
            'paketKorisnikaID' => $paketKorisnika->id,
        ];

        $response = $this->putJson(
            route('api.paket-biljakas.update', $paketBiljaka),
            $data
        );

        $data['id'] = $paketBiljaka->id;

        $this->assertDatabaseHas('paket_biljakas', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_paket_biljaka(): void
    {
        $paketBiljaka = PaketBiljaka::factory()->create();

        $response = $this->deleteJson(
            route('api.paket-biljakas.destroy', $paketBiljaka)
        );

        $this->assertModelMissing($paketBiljaka);

        $response->assertNoContent();
    }
}
