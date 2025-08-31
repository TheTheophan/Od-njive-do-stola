<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\TipPaketa;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TipPaketaControllerTest extends TestCase
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
    public function it_displays_index_view_with_tip_paketas(): void
    {
        $tipPaketas = TipPaketa::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('tip-paketas.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.tip_paketas.index')
            ->assertViewHas('tipPaketas');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_tip_paketa(): void
    {
        $response = $this->get(route('tip-paketas.create'));

        $response->assertOk()->assertViewIs('app.tip_paketas.create');
    }

    /**
     * @test
     */
    public function it_stores_the_tip_paketa(): void
    {
        $data = TipPaketa::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('tip-paketas.store'), $data);

        $this->assertDatabaseHas('tip_paketas', $data);

        $tipPaketa = TipPaketa::latest('id')->first();

        $response->assertRedirect(route('tip-paketas.edit', $tipPaketa));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_tip_paketa(): void
    {
        $tipPaketa = TipPaketa::factory()->create();

        $response = $this->get(route('tip-paketas.show', $tipPaketa));

        $response
            ->assertOk()
            ->assertViewIs('app.tip_paketas.show')
            ->assertViewHas('tipPaketa');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_tip_paketa(): void
    {
        $tipPaketa = TipPaketa::factory()->create();

        $response = $this->get(route('tip-paketas.edit', $tipPaketa));

        $response
            ->assertOk()
            ->assertViewIs('app.tip_paketas.edit')
            ->assertViewHas('tipPaketa');
    }

    /**
     * @test
     */
    public function it_updates_the_tip_paketa(): void
    {
        $tipPaketa = TipPaketa::factory()->create();

        $data = [];

        $response = $this->put(route('tip-paketas.update', $tipPaketa), $data);

        $data['id'] = $tipPaketa->id;

        $this->assertDatabaseHas('tip_paketas', $data);

        $response->assertRedirect(route('tip-paketas.edit', $tipPaketa));
    }

    /**
     * @test
     */
    public function it_deletes_the_tip_paketa(): void
    {
        $tipPaketa = TipPaketa::factory()->create();

        $response = $this->delete(route('tip-paketas.destroy', $tipPaketa));

        $response->assertRedirect(route('tip-paketas.index'));

        $this->assertModelMissing($tipPaketa);
    }
}
