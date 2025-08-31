<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Slika;

use App\Models\Poljoprivrednik;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SlikaTest extends TestCase
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
    public function it_gets_slikas_list(): void
    {
        $slikas = Slika::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.slikas.index'));

        $response->assertOk()->assertSee($slikas[0]->upotrebaSlike);
    }

    /**
     * @test
     */
    public function it_stores_the_slika(): void
    {
        $data = Slika::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.slikas.store'), $data);

        $this->assertDatabaseHas('slikas', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_slika(): void
    {
        $slika = Slika::factory()->create();

        $poljoprivrednik = Poljoprivrednik::factory()->create();

        $data = [
            'poljoprivrednikID' => $poljoprivrednik->id,
        ];

        $response = $this->putJson(route('api.slikas.update', $slika), $data);

        $data['id'] = $slika->id;

        $this->assertDatabaseHas('slikas', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_slika(): void
    {
        $slika = Slika::factory()->create();

        $response = $this->deleteJson(route('api.slikas.destroy', $slika));

        $this->assertModelMissing($slika);

        $response->assertNoContent();
    }
}
