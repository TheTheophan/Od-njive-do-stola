<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Poljoprivrednik;

use App\Models\Grad;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PoljoprivrednikControllerTest extends TestCase
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
    public function it_displays_index_view_with_poljoprivredniks(): void
    {
        $poljoprivredniks = Poljoprivrednik::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('poljoprivredniks.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.poljoprivredniks.index')
            ->assertViewHas('poljoprivredniks');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_poljoprivrednik(): void
    {
        $response = $this->get(route('poljoprivredniks.create'));

        $response->assertOk()->assertViewIs('app.poljoprivredniks.create');
    }

    /**
     * @test
     */
    public function it_stores_the_poljoprivrednik(): void
    {
        $data = Poljoprivrednik::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('poljoprivredniks.store'), $data);

        $this->assertDatabaseHas('poljoprivredniks', $data);

        $poljoprivrednik = Poljoprivrednik::latest('id')->first();

        $response->assertRedirect(
            route('poljoprivredniks.edit', $poljoprivrednik)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_poljoprivrednik(): void
    {
        $poljoprivrednik = Poljoprivrednik::factory()->create();

        $response = $this->get(
            route('poljoprivredniks.show', $poljoprivrednik)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.poljoprivredniks.show')
            ->assertViewHas('poljoprivrednik');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_poljoprivrednik(): void
    {
        $poljoprivrednik = Poljoprivrednik::factory()->create();

        $response = $this->get(
            route('poljoprivredniks.edit', $poljoprivrednik)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.poljoprivredniks.edit')
            ->assertViewHas('poljoprivrednik');
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

        $response = $this->put(
            route('poljoprivredniks.update', $poljoprivrednik),
            $data
        );

        $data['id'] = $poljoprivrednik->id;

        $this->assertDatabaseHas('poljoprivredniks', $data);

        $response->assertRedirect(
            route('poljoprivredniks.edit', $poljoprivrednik)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_poljoprivrednik(): void
    {
        $poljoprivrednik = Poljoprivrednik::factory()->create();

        $response = $this->delete(
            route('poljoprivredniks.destroy', $poljoprivrednik)
        );

        $response->assertRedirect(route('poljoprivredniks.index'));

        $this->assertModelMissing($poljoprivrednik);
    }
}
