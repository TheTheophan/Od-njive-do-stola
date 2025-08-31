<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Slika;

use App\Models\Poljoprivrednik;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SlikaControllerTest extends TestCase
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
    public function it_displays_index_view_with_slikas(): void
    {
        $slikas = Slika::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('slikas.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.slikas.index')
            ->assertViewHas('slikas');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_slika(): void
    {
        $response = $this->get(route('slikas.create'));

        $response->assertOk()->assertViewIs('app.slikas.create');
    }

    /**
     * @test
     */
    public function it_stores_the_slika(): void
    {
        $data = Slika::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('slikas.store'), $data);

        $this->assertDatabaseHas('slikas', $data);

        $slika = Slika::latest('id')->first();

        $response->assertRedirect(route('slikas.edit', $slika));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_slika(): void
    {
        $slika = Slika::factory()->create();

        $response = $this->get(route('slikas.show', $slika));

        $response
            ->assertOk()
            ->assertViewIs('app.slikas.show')
            ->assertViewHas('slika');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_slika(): void
    {
        $slika = Slika::factory()->create();

        $response = $this->get(route('slikas.edit', $slika));

        $response
            ->assertOk()
            ->assertViewIs('app.slikas.edit')
            ->assertViewHas('slika');
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

        $response = $this->put(route('slikas.update', $slika), $data);

        $data['id'] = $slika->id;

        $this->assertDatabaseHas('slikas', $data);

        $response->assertRedirect(route('slikas.edit', $slika));
    }

    /**
     * @test
     */
    public function it_deletes_the_slika(): void
    {
        $slika = Slika::factory()->create();

        $response = $this->delete(route('slikas.destroy', $slika));

        $response->assertRedirect(route('slikas.index'));

        $this->assertModelMissing($slika);
    }
}
