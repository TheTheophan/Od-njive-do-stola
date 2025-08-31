<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Poljoprivrednik;
use App\Models\BiljkaPoljoprivrednika;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PoljoprivrednikBiljkaPoljoprivrednikasTest extends TestCase
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
    public function it_gets_poljoprivrednik_biljka_poljoprivrednikas(): void
    {
        $poljoprivrednik = Poljoprivrednik::factory()->create();
        $biljkaPoljoprivrednikas = BiljkaPoljoprivrednika::factory()
            ->count(2)
            ->create([
                'poljoprivrednikID' => $poljoprivrednik->id,
            ]);

        $response = $this->getJson(
            route(
                'api.poljoprivredniks.biljka-poljoprivrednikas.index',
                $poljoprivrednik
            )
        );

        $response
            ->assertOk()
            ->assertSee($biljkaPoljoprivrednikas[0]->stanjeBiljke);
    }

    /**
     * @test
     */
    public function it_stores_the_poljoprivrednik_biljka_poljoprivrednikas(): void
    {
        $poljoprivrednik = Poljoprivrednik::factory()->create();
        $data = BiljkaPoljoprivrednika::factory()
            ->make([
                'poljoprivrednikID' => $poljoprivrednik->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route(
                'api.poljoprivredniks.biljka-poljoprivrednikas.store',
                $poljoprivrednik
            ),
            $data
        );

        $this->assertDatabaseHas('biljka_poljoprivrednikas', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $biljkaPoljoprivrednika = BiljkaPoljoprivrednika::latest('id')->first();

        $this->assertEquals(
            $poljoprivrednik->id,
            $biljkaPoljoprivrednika->poljoprivrednikID
        );
    }
}
