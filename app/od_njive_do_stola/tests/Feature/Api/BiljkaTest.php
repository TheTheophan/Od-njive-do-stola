<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Biljka;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BiljkaTest extends TestCase
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
    public function it_gets_biljkas_list(): void
    {
        $biljkas = Biljka::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.biljkas.index'));

        $response->assertOk()->assertSee($biljkas[0]->opisBiljke);
    }

    /**
     * @test
     */
    public function it_stores_the_biljka(): void
    {
        $data = Biljka::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.biljkas.store'), $data);

        $this->assertDatabaseHas('biljkas', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_biljka(): void
    {
        $biljka = Biljka::factory()->create();

        $data = [];

        $response = $this->putJson(route('api.biljkas.update', $biljka), $data);

        $data['id'] = $biljka->id;

        $this->assertDatabaseHas('biljkas', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_biljka(): void
    {
        $biljka = Biljka::factory()->create();

        $response = $this->deleteJson(route('api.biljkas.destroy', $biljka));

        $this->assertModelMissing($biljka);

        $response->assertNoContent();
    }
}
