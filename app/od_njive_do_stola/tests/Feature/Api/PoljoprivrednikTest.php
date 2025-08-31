<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Poljoprivrednik;

use App\Models\Grad;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PoljoprivrednikTest extends TestCase
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
    public function it_gets_poljoprivredniks_list(): void
    {
        $poljoprivredniks = Poljoprivrednik::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.poljoprivredniks.index'));

        $response->assertOk()->assertSee($poljoprivredniks[0]->adresa);
    }

    /**
     * @test
     */
    public function it_stores_the_poljoprivrednik(): void
    {
        $data = Poljoprivrednik::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.poljoprivredniks.store'), $data);

        $this->assertDatabaseHas('poljoprivredniks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_poljoprivrednik(): void
    {
        $poljoprivrednik = Poljoprivrednik::factory()->create();

        $grad = Grad::factory()->create();

        $data = [
            'gradID' => $grad->id,
        ];

        $response = $this->putJson(
            route('api.poljoprivredniks.update', $poljoprivrednik),
            $data
        );

        $data['id'] = $poljoprivrednik->id;

        $this->assertDatabaseHas('poljoprivredniks', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_poljoprivrednik(): void
    {
        $poljoprivrednik = Poljoprivrednik::factory()->create();

        $response = $this->deleteJson(
            route('api.poljoprivredniks.destroy', $poljoprivrednik)
        );

        $this->assertModelMissing($poljoprivrednik);

        $response->assertNoContent();
    }
}
