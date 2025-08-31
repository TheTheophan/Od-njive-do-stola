<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\BiljkaPoljoprivrednika;

use App\Models\Biljka;
use App\Models\Poljoprivrednik;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BiljkaPoljoprivrednikaTest extends TestCase
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
    public function it_gets_biljka_poljoprivrednikas_list(): void
    {
        $biljkaPoljoprivrednikas = BiljkaPoljoprivrednika::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.biljka-poljoprivrednikas.index'));

        $response
            ->assertOk()
            ->assertSee($biljkaPoljoprivrednikas[0]->stanjeBiljke);
    }

    /**
     * @test
     */
    public function it_stores_the_biljka_poljoprivrednika(): void
    {
        $data = BiljkaPoljoprivrednika::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.biljka-poljoprivrednikas.store'),
            $data
        );

        $this->assertDatabaseHas('biljka_poljoprivrednikas', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_biljka_poljoprivrednika(): void
    {
        $biljkaPoljoprivrednika = BiljkaPoljoprivrednika::factory()->create();

        $biljka = Biljka::factory()->create();
        $poljoprivrednik = Poljoprivrednik::factory()->create();

        $data = [
            'biljkaID' => $this->faker->randomNumber(),
            'poljoprivrednikID' => $this->faker->randomNumber(),
            'biljkaID' => $biljka->id,
            'poljoprivrednikID' => $poljoprivrednik->id,
        ];

        $response = $this->putJson(
            route(
                'api.biljka-poljoprivrednikas.update',
                $biljkaPoljoprivrednika
            ),
            $data
        );

        $data['id'] = $biljkaPoljoprivrednika->id;

        $this->assertDatabaseHas('biljka_poljoprivrednikas', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_biljka_poljoprivrednika(): void
    {
        $biljkaPoljoprivrednika = BiljkaPoljoprivrednika::factory()->create();

        $response = $this->deleteJson(
            route(
                'api.biljka-poljoprivrednikas.destroy',
                $biljkaPoljoprivrednika
            )
        );

        $this->assertModelMissing($biljkaPoljoprivrednika);

        $response->assertNoContent();
    }
}
