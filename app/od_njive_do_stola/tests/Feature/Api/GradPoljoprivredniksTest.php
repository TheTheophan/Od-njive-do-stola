<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Grad;
use App\Models\Poljoprivrednik;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GradPoljoprivredniksTest extends TestCase
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
    public function it_gets_grad_poljoprivredniks(): void
    {
        $grad = Grad::factory()->create();
        $poljoprivredniks = Poljoprivrednik::factory()
            ->count(2)
            ->create([
                'gradID' => $grad->id,
            ]);

        $response = $this->getJson(
            route('api.grads.poljoprivredniks.index', $grad)
        );

        $response->assertOk()->assertSee($poljoprivredniks[0]->adresa);
    }

    /**
     * @test
     */
    public function it_stores_the_grad_poljoprivredniks(): void
    {
        $grad = Grad::factory()->create();
        $data = Poljoprivrednik::factory()
            ->make([
                'gradID' => $grad->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.grads.poljoprivredniks.store', $grad),
            $data
        );

        $this->assertDatabaseHas('poljoprivredniks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $poljoprivrednik = Poljoprivrednik::latest('id')->first();

        $this->assertEquals($grad->id, $poljoprivrednik->gradID);
    }
}
