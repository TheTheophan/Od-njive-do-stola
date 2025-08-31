<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\BiljkaPoljoprivrednika;

use App\Models\Biljka;
use App\Models\Poljoprivrednik;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BiljkaPoljoprivrednikaControllerTest extends TestCase
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
    public function it_displays_index_view_with_biljka_poljoprivrednikas(): void
    {
        $biljkaPoljoprivrednikas = BiljkaPoljoprivrednika::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('biljka-poljoprivrednikas.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.biljka_poljoprivrednikas.index')
            ->assertViewHas('biljkaPoljoprivrednikas');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_biljka_poljoprivrednika(): void
    {
        $response = $this->get(route('biljka-poljoprivrednikas.create'));

        $response
            ->assertOk()
            ->assertViewIs('app.biljka_poljoprivrednikas.create');
    }

    /**
     * @test
     */
    public function it_stores_the_biljka_poljoprivrednika(): void
    {
        $data = BiljkaPoljoprivrednika::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('biljka-poljoprivrednikas.store'), $data);

        $this->assertDatabaseHas('biljka_poljoprivrednikas', $data);

        $biljkaPoljoprivrednika = BiljkaPoljoprivrednika::latest('id')->first();

        $response->assertRedirect(
            route('biljka-poljoprivrednikas.edit', $biljkaPoljoprivrednika)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_biljka_poljoprivrednika(): void
    {
        $biljkaPoljoprivrednika = BiljkaPoljoprivrednika::factory()->create();

        $response = $this->get(
            route('biljka-poljoprivrednikas.show', $biljkaPoljoprivrednika)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.biljka_poljoprivrednikas.show')
            ->assertViewHas('biljkaPoljoprivrednika');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_biljka_poljoprivrednika(): void
    {
        $biljkaPoljoprivrednika = BiljkaPoljoprivrednika::factory()->create();

        $response = $this->get(
            route('biljka-poljoprivrednikas.edit', $biljkaPoljoprivrednika)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.biljka_poljoprivrednikas.edit')
            ->assertViewHas('biljkaPoljoprivrednika');
    }

    /**
     * @test
     */
    public function it_updates_the_biljka_poljoprivrednika(): void
    {
        $biljkaPoljoprivrednika = BiljkaPoljoprivrednika::factory()->create();

        $biljka = Biljka::factory()->create();
        $poljoprivrednik = Poljoprivrednik::factory()->create();

        $data = [
            'biljkaID' => $this->faker->randomNumber(),
            'poljoprivrednikID' => $this->faker->randomNumber(),
            'biljkaID' => $biljka->id,
            'poljoprivrednikID' => $poljoprivrednik->id,
        ];

        $response = $this->put(
            route('biljka-poljoprivrednikas.update', $biljkaPoljoprivrednika),
            $data
        );

        $data['id'] = $biljkaPoljoprivrednika->id;

        $this->assertDatabaseHas('biljka_poljoprivrednikas', $data);

        $response->assertRedirect(
            route('biljka-poljoprivrednikas.edit', $biljkaPoljoprivrednika)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_biljka_poljoprivrednika(): void
    {
        $biljkaPoljoprivrednika = BiljkaPoljoprivrednika::factory()->create();

        $response = $this->delete(
            route('biljka-poljoprivrednikas.destroy', $biljkaPoljoprivrednika)
        );

        $response->assertRedirect(route('biljka-poljoprivrednikas.index'));

        $this->assertModelMissing($biljkaPoljoprivrednika);
    }
}
