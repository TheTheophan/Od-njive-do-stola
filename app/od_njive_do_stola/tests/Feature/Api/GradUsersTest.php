<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Grad;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GradUsersTest extends TestCase
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
    public function it_gets_grad_users(): void
    {
        $grad = Grad::factory()->create();
        $users = User::factory()
            ->count(2)
            ->create([
                'gradID' => $grad->id,
            ]);

        $response = $this->getJson(route('api.grads.users.index', $grad));

        $response->assertOk()->assertSee($users[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_grad_users(): void
    {
        $grad = Grad::factory()->create();
        $data = User::factory()
            ->make([
                'gradID' => $grad->id,
            ])
            ->toArray();
        $data['password'] = \Str::random('8');

        $response = $this->postJson(
            route('api.grads.users.store', $grad),
            $data
        );

        unset($data['password']);
        unset($data['email_verified_at']);

        $this->assertDatabaseHas('users', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $user = User::latest('id')->first();

        $this->assertEquals($grad->id, $user->gradID);
    }
}
