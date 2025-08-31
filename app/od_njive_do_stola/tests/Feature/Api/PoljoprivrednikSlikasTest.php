<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Slika;
use App\Models\Poljoprivrednik;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PoljoprivrednikSlikasTest extends TestCase
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
    public function it_gets_poljoprivrednik_slikas(): void
    {
        $poljoprivrednik = Poljoprivrednik::factory()->create();
        $slikas = Slika::factory()
            ->count(2)
            ->create([
                'poljoprivrednikID' => $poljoprivrednik->id,
            ]);

        $response = $this->getJson(
            route('api.poljoprivredniks.slikas.index', $poljoprivrednik)
        );

        $response->assertOk()->assertSee($slikas[0]->upotrebaSlike);
    }

    /**
     * @test
     */
    public function it_stores_the_poljoprivrednik_slikas(): void
    {
        $poljoprivrednik = Poljoprivrednik::factory()->create();
        $data = Slika::factory()
            ->make([
                'poljoprivrednikID' => $poljoprivrednik->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.poljoprivredniks.slikas.store', $poljoprivrednik),
            $data
        );

        $this->assertDatabaseHas('slikas', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $slika = Slika::latest('id')->first();

        $this->assertEquals($poljoprivrednik->id, $slika->poljoprivrednikID);
    }
}
