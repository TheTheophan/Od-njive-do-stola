<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\PaketBiljaka;
use App\Models\PaketKorisnika;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaketKorisnikaPaketBiljakasTest extends TestCase
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
    public function it_gets_paket_korisnika_paket_biljakas(): void
    {
        $paketKorisnika = PaketKorisnika::factory()->create();
        $paketBiljakas = PaketBiljaka::factory()
            ->count(2)
            ->create([
                'paketKorisnikaID' => $paketKorisnika->id,
            ]);

        $response = $this->getJson(
            route('api.paket-korisnikas.paket-biljakas.index', $paketKorisnika)
        );

        $response->assertOk()->assertSee($paketBiljakas[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_paket_korisnika_paket_biljakas(): void
    {
        $paketKorisnika = PaketKorisnika::factory()->create();
        $data = PaketBiljaka::factory()
            ->make([
                'paketKorisnikaID' => $paketKorisnika->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.paket-korisnikas.paket-biljakas.store', $paketKorisnika),
            $data
        );

        $this->assertDatabaseHas('paket_biljakas', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $paketBiljaka = PaketBiljaka::latest('id')->first();

        $this->assertEquals(
            $paketKorisnika->id,
            $paketBiljaka->paketKorisnikaID
        );
    }
}
