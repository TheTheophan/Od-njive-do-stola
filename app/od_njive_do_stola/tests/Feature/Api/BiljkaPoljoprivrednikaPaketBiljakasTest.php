<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\PaketBiljaka;
use App\Models\BiljkaPoljoprivrednika;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BiljkaPoljoprivrednikaPaketBiljakasTest extends TestCase
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
    public function it_gets_biljka_poljoprivrednika_paket_biljakas(): void
    {
        $biljkaPoljoprivrednika = BiljkaPoljoprivrednika::factory()->create();
        $paketBiljakas = PaketBiljaka::factory()
            ->count(2)
            ->create([
                'biljkaPoljoprivrednikaID' => $biljkaPoljoprivrednika->id,
            ]);

        $response = $this->getJson(
            route(
                'api.biljka-poljoprivrednikas.paket-biljakas.index',
                $biljkaPoljoprivrednika
            )
        );

        $response->assertOk()->assertSee($paketBiljakas[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_biljka_poljoprivrednika_paket_biljakas(): void
    {
        $biljkaPoljoprivrednika = BiljkaPoljoprivrednika::factory()->create();
        $data = PaketBiljaka::factory()
            ->make([
                'biljkaPoljoprivrednikaID' => $biljkaPoljoprivrednika->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route(
                'api.biljka-poljoprivrednikas.paket-biljakas.store',
                $biljkaPoljoprivrednika
            ),
            $data
        );

        $this->assertDatabaseHas('paket_biljakas', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $paketBiljaka = PaketBiljaka::latest('id')->first();

        $this->assertEquals(
            $biljkaPoljoprivrednika->id,
            $paketBiljaka->biljkaPoljoprivrednikaID
        );
    }
}
