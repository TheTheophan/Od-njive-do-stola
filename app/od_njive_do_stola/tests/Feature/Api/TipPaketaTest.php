<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\TipPaketa;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TipPaketaTest extends TestCase
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
    public function it_gets_tip_paketas_list(): void
    {
        $tipPaketas = TipPaketa::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.tip-paketas.index'));

        $response->assertOk()->assertSee($tipPaketas[0]->opisPaketa);
    }

    /**
     * @test
     */
    public function it_stores_the_tip_paketa(): void
    {
        $data = TipPaketa::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.tip-paketas.store'), $data);

        $this->assertDatabaseHas('tip_paketas', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_tip_paketa(): void
    {
        $tipPaketa = TipPaketa::factory()->create();

        $data = [];

        $response = $this->putJson(
            route('api.tip-paketas.update', $tipPaketa),
            $data
        );

        $data['id'] = $tipPaketa->id;

        $this->assertDatabaseHas('tip_paketas', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_tip_paketa(): void
    {
        $tipPaketa = TipPaketa::factory()->create();

        $response = $this->deleteJson(
            route('api.tip-paketas.destroy', $tipPaketa)
        );

        $this->assertModelMissing($tipPaketa);

        $response->assertNoContent();
    }
}
