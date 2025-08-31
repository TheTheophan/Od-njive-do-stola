<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\PaketBiljaka;

use App\Models\PaketKorisnika;
use App\Models\BiljkaPoljoprivrednika;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaketBiljakaControllerTest extends TestCase
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
    public function it_displays_index_view_with_paket_biljakas(): void
    {
        $paketBiljakas = PaketBiljaka::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('paket-biljakas.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.paket_biljakas.index')
            ->assertViewHas('paketBiljakas');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_paket_biljaka(): void
    {
        $response = $this->get(route('paket-biljakas.create'));

        $response->assertOk()->assertViewIs('app.paket_biljakas.create');
    }

    /**
     * @test
     */
    public function it_stores_the_paket_biljaka(): void
    {
        $data = PaketBiljaka::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('paket-biljakas.store'), $data);

        $this->assertDatabaseHas('paket_biljakas', $data);

        $paketBiljaka = PaketBiljaka::latest('id')->first();

        $response->assertRedirect(route('paket-biljakas.edit', $paketBiljaka));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_paket_biljaka(): void
    {
        $paketBiljaka = PaketBiljaka::factory()->create();

        $response = $this->get(route('paket-biljakas.show', $paketBiljaka));

        $response
            ->assertOk()
            ->assertViewIs('app.paket_biljakas.show')
            ->assertViewHas('paketBiljaka');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_paket_biljaka(): void
    {
        $paketBiljaka = PaketBiljaka::factory()->create();

        $response = $this->get(route('paket-biljakas.edit', $paketBiljaka));

        $response
            ->assertOk()
            ->assertViewIs('app.paket_biljakas.edit')
            ->assertViewHas('paketBiljaka');
    }

    /**
     * @test
     */
    public function it_updates_the_paket_biljaka(): void
    {
        $paketBiljaka = PaketBiljaka::factory()->create();

        $biljkaPoljoprivrednika = BiljkaPoljoprivrednika::factory()->create();
        $paketKorisnika = PaketKorisnika::factory()->create();

        $data = [
            'biljkaPoljoprivrednikaID' => $biljkaPoljoprivrednika->id,
            'paketKorisnikaID' => $paketKorisnika->id,
        ];

        $response = $this->put(
            route('paket-biljakas.update', $paketBiljaka),
            $data
        );

        $data['id'] = $paketBiljaka->id;

        $this->assertDatabaseHas('paket_biljakas', $data);

        $response->assertRedirect(route('paket-biljakas.edit', $paketBiljaka));
    }

    /**
     * @test
     */
    public function it_deletes_the_paket_biljaka(): void
    {
        $paketBiljaka = PaketBiljaka::factory()->create();

        $response = $this->delete(
            route('paket-biljakas.destroy', $paketBiljaka)
        );

        $response->assertRedirect(route('paket-biljakas.index'));

        $this->assertModelMissing($paketBiljaka);
    }
}
