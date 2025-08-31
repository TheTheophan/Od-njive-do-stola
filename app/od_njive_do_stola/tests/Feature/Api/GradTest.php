<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Grad;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GradTest extends TestCase
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
    public function it_gets_grads_list(): void
    {
        $grads = Grad::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.grads.index'));

        $response->assertOk()->assertSee($grads[0]->nazivGrada);
    }

    /**
     * @test
     */
    public function it_stores_the_grad(): void
    {
        $data = Grad::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.grads.store'), $data);

        $this->assertDatabaseHas('grads', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_grad(): void
    {
        $grad = Grad::factory()->create();

        $data = [];

        $response = $this->putJson(route('api.grads.update', $grad), $data);

        $data['id'] = $grad->id;

        $this->assertDatabaseHas('grads', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_grad(): void
    {
        $grad = Grad::factory()->create();

        $response = $this->deleteJson(route('api.grads.destroy', $grad));

        $this->assertModelMissing($grad);

        $response->assertNoContent();
    }
}
