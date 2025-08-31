<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Grad;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GradControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_grads(): void
    {
        $grads = Grad::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('grads.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.grads.index')
            ->assertViewHas('grads');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_grad(): void
    {
        $response = $this->get(route('grads.create'));

        $response->assertOk()->assertViewIs('app.grads.create');
    }

    /**
     * @test
     */
    public function it_stores_the_grad(): void
    {
        $data = Grad::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('grads.store'), $data);

        $this->assertDatabaseHas('grads', $data);

        $grad = Grad::latest('id')->first();

        $response->assertRedirect(route('grads.edit', $grad));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_grad(): void
    {
        $grad = Grad::factory()->create();

        $response = $this->get(route('grads.show', $grad));

        $response
            ->assertOk()
            ->assertViewIs('app.grads.show')
            ->assertViewHas('grad');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_grad(): void
    {
        $grad = Grad::factory()->create();

        $response = $this->get(route('grads.edit', $grad));

        $response
            ->assertOk()
            ->assertViewIs('app.grads.edit')
            ->assertViewHas('grad');
    }

    /**
     * @test
     */
    public function it_updates_the_grad(): void
    {
        $grad = Grad::factory()->create();

        $data = [];

        $response = $this->put(route('grads.update', $grad), $data);

        $data['id'] = $grad->id;

        $this->assertDatabaseHas('grads', $data);

        $response->assertRedirect(route('grads.edit', $grad));
    }

    /**
     * @test
     */
    public function it_deletes_the_grad(): void
    {
        $grad = Grad::factory()->create();

        $response = $this->delete(route('grads.destroy', $grad));

        $response->assertRedirect(route('grads.index'));

        $this->assertModelMissing($grad);
    }
}
