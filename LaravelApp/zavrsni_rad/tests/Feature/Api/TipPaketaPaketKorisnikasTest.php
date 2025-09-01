<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\TipPaketa;
use App\Models\PaketKorisnika;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TipPaketaPaketKorisnikasTest extends TestCase
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
    public function it_gets_tip_paketa_paket_korisnikas(): void
    {
        $tipPaketa = TipPaketa::factory()->create();
        $paketKorisnikas = PaketKorisnika::factory()
            ->count(2)
            ->create([
                'tip_paketa_id' => $tipPaketa->id,
            ]);

        $response = $this->getJson(
            route('api.tip-paketas.paket-korisnikas.index', $tipPaketa)
        );

        $response->assertOk()->assertSee($paketKorisnikas[0]->adresa);
    }

    /**
     * @test
     */
    public function it_stores_the_tip_paketa_paket_korisnikas(): void
    {
        $tipPaketa = TipPaketa::factory()->create();
        $data = PaketKorisnika::factory()
            ->make([
                'tip_paketa_id' => $tipPaketa->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.tip-paketas.paket-korisnikas.store', $tipPaketa),
            $data
        );

        $this->assertDatabaseHas('paket_korisnikas', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $paketKorisnika = PaketKorisnika::latest('id')->first();

        $this->assertEquals($tipPaketa->id, $paketKorisnika->tip_paketa_id);
    }
}
