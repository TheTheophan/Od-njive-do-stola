<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Faktura;

use App\Models\PaketKorisnika;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FakturaControllerTest extends TestCase
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
    public function it_displays_index_view_with_fakturas(): void
    {
        $fakturas = Faktura::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('fakturas.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.fakturas.index')
            ->assertViewHas('fakturas');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_faktura(): void
    {
        $response = $this->get(route('fakturas.create'));

        $response->assertOk()->assertViewIs('app.fakturas.create');
    }

    /**
     * @test
     */
    public function it_stores_the_faktura(): void
    {
        $data = Faktura::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('fakturas.store'), $data);

        $this->assertDatabaseHas('fakturas', $data);

        $faktura = Faktura::latest('id')->first();

        $response->assertRedirect(route('fakturas.edit', $faktura));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_faktura(): void
    {
        $faktura = Faktura::factory()->create();

        $response = $this->get(route('fakturas.show', $faktura));

        $response
            ->assertOk()
            ->assertViewIs('app.fakturas.show')
            ->assertViewHas('faktura');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_faktura(): void
    {
        $faktura = Faktura::factory()->create();

        $response = $this->get(route('fakturas.edit', $faktura));

        $response
            ->assertOk()
            ->assertViewIs('app.fakturas.edit')
            ->assertViewHas('faktura');
    }

    /**
     * @test
     */
    public function it_updates_the_faktura(): void
    {
        $faktura = Faktura::factory()->create();

        $paketKorisnika = PaketKorisnika::factory()->create();

        $data = [
            'paketKorisnikaID' => $paketKorisnika->id,
        ];

        $response = $this->put(route('fakturas.update', $faktura), $data);

        $data['id'] = $faktura->id;

        $this->assertDatabaseHas('fakturas', $data);

        $response->assertRedirect(route('fakturas.edit', $faktura));
    }

    /**
     * @test
     */
    public function it_deletes_the_faktura(): void
    {
        $faktura = Faktura::factory()->create();

        $response = $this->delete(route('fakturas.destroy', $faktura));

        $response->assertRedirect(route('fakturas.index'));

        $this->assertModelMissing($faktura);
    }
}
