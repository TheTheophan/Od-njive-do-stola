<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\PaketKorisnika;

use App\Models\TipPaketa;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaketKorisnikaControllerTest extends TestCase
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
    public function it_displays_index_view_with_paket_korisnikas(): void
    {
        $paketKorisnikas = PaketKorisnika::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('paket-korisnikas.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.paket_korisnikas.index')
            ->assertViewHas('paketKorisnikas');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_paket_korisnika(): void
    {
        $response = $this->get(route('paket-korisnikas.create'));

        $response->assertOk()->assertViewIs('app.paket_korisnikas.create');
    }

    /**
     * @test
     */
    public function it_stores_the_paket_korisnika(): void
    {
        $data = PaketKorisnika::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('paket-korisnikas.store'), $data);

        $this->assertDatabaseHas('paket_korisnikas', $data);

        $paketKorisnika = PaketKorisnika::latest('id')->first();

        $response->assertRedirect(
            route('paket-korisnikas.edit', $paketKorisnika)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_paket_korisnika(): void
    {
        $paketKorisnika = PaketKorisnika::factory()->create();

        $response = $this->get(route('paket-korisnikas.show', $paketKorisnika));

        $response
            ->assertOk()
            ->assertViewIs('app.paket_korisnikas.show')
            ->assertViewHas('paketKorisnika');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_paket_korisnika(): void
    {
        $paketKorisnika = PaketKorisnika::factory()->create();

        $response = $this->get(route('paket-korisnikas.edit', $paketKorisnika));

        $response
            ->assertOk()
            ->assertViewIs('app.paket_korisnikas.edit')
            ->assertViewHas('paketKorisnika');
    }

    /**
     * @test
     */
    public function it_updates_the_paket_korisnika(): void
    {
        $paketKorisnika = PaketKorisnika::factory()->create();

        $user = User::factory()->create();
        $tipPaketa = TipPaketa::factory()->create();

        $data = [
            'userID' => $user->id,
            'tipPaketaID' => $tipPaketa->id,
        ];

        $response = $this->put(
            route('paket-korisnikas.update', $paketKorisnika),
            $data
        );

        $data['id'] = $paketKorisnika->id;

        $this->assertDatabaseHas('paket_korisnikas', $data);

        $response->assertRedirect(
            route('paket-korisnikas.edit', $paketKorisnika)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_paket_korisnika(): void
    {
        $paketKorisnika = PaketKorisnika::factory()->create();

        $response = $this->delete(
            route('paket-korisnikas.destroy', $paketKorisnika)
        );

        $response->assertRedirect(route('paket-korisnikas.index'));

        $this->assertModelMissing($paketKorisnika);
    }
}
