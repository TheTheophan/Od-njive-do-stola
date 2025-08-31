<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Biljka;
use App\Models\BiljkaPoljoprivrednika;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BiljkaBiljkaPoljoprivrednikasTest extends TestCase
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
    public function it_gets_biljka_biljka_poljoprivrednikas(): void
    {
        $biljka = Biljka::factory()->create();
        $biljkaPoljoprivrednikas = BiljkaPoljoprivrednika::factory()
            ->count(2)
            ->create([
                'biljkaID' => $biljka->id,
            ]);

        $response = $this->getJson(
            route('api.biljkas.biljka-poljoprivrednikas.index', $biljka)
        );

        $response
            ->assertOk()
            ->assertSee($biljkaPoljoprivrednikas[0]->stanjeBiljke);
    }

    /**
     * @test
     */
    public function it_stores_the_biljka_biljka_poljoprivrednikas(): void
    {
        $biljka = Biljka::factory()->create();
        $data = BiljkaPoljoprivrednika::factory()
            ->make([
                'biljkaID' => $biljka->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.biljkas.biljka-poljoprivrednikas.store', $biljka),
            $data
        );

        $this->assertDatabaseHas('biljka_poljoprivrednikas', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $biljkaPoljoprivrednika = BiljkaPoljoprivrednika::latest('id')->first();

        $this->assertEquals($biljka->id, $biljkaPoljoprivrednika->biljkaID);
    }
}
