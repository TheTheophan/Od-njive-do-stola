<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Biljka;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BiljkaControllerTest extends TestCase
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
    public function it_displays_index_view_with_biljkas(): void
    {
        $biljkas = Biljka::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('biljkas.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.biljkas.index')
            ->assertViewHas('biljkas');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_biljka(): void
    {
        $response = $this->get(route('biljkas.create'));

        $response->assertOk()->assertViewIs('app.biljkas.create');
    }

    /**
     * @test
     */
    public function it_stores_the_biljka(): void
    {
        $data = Biljka::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('biljkas.store'), $data);

        $this->assertDatabaseHas('biljkas', $data);

        $biljka = Biljka::latest('id')->first();

        $response->assertRedirect(route('biljkas.edit', $biljka));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_biljka(): void
    {
        $biljka = Biljka::factory()->create();

        $response = $this->get(route('biljkas.show', $biljka));

        $response
            ->assertOk()
            ->assertViewIs('app.biljkas.show')
            ->assertViewHas('biljka');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_biljka(): void
    {
        $biljka = Biljka::factory()->create();

        $response = $this->get(route('biljkas.edit', $biljka));

        $response
            ->assertOk()
            ->assertViewIs('app.biljkas.edit')
            ->assertViewHas('biljka');
    }

    /**
     * @test
     */
    public function it_updates_the_biljka(): void
    {
        $biljka = Biljka::factory()->create();

        $data = [];

        $response = $this->put(route('biljkas.update', $biljka), $data);

        $data['id'] = $biljka->id;

        $this->assertDatabaseHas('biljkas', $data);

        $response->assertRedirect(route('biljkas.edit', $biljka));
    }

    /**
     * @test
     */
    public function it_deletes_the_biljka(): void
    {
        $biljka = Biljka::factory()->create();

        $response = $this->delete(route('biljkas.destroy', $biljka));

        $response->assertRedirect(route('biljkas.index'));

        $this->assertModelMissing($biljka);
    }
}
