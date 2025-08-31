<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Poljoprivrednik;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PoljoprivrednikUsersTest extends TestCase
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
    public function it_gets_poljoprivrednik_users(): void
    {
        $poljoprivrednik = Poljoprivrednik::factory()->create();
        $users = User::factory()
            ->count(2)
            ->create([
                'poljoprivrednikID' => $poljoprivrednik->id,
            ]);

        $response = $this->getJson(
            route('api.poljoprivredniks.users.index', $poljoprivrednik)
        );

        $response->assertOk()->assertSee($users[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_poljoprivrednik_users(): void
    {
        $poljoprivrednik = Poljoprivrednik::factory()->create();
        $data = User::factory()
            ->make([
                'poljoprivrednikID' => $poljoprivrednik->id,
            ])
            ->toArray();
        $data['password'] = \Str::random('8');

        $response = $this->postJson(
            route('api.poljoprivredniks.users.store', $poljoprivrednik),
            $data
        );

        unset($data['password']);
        unset($data['email_verified_at']);

        $this->assertDatabaseHas('users', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $user = User::latest('id')->first();

        $this->assertEquals($poljoprivrednik->id, $user->poljoprivrednikID);
    }
}
