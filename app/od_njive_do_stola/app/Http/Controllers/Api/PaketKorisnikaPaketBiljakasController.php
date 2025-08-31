<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\PaketKorisnika;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaketBiljakaResource;
use App\Http\Resources\PaketBiljakaCollection;

class PaketKorisnikaPaketBiljakasController extends Controller
{
    public function index(
        Request $request,
        PaketKorisnika $paketKorisnika
    ): PaketBiljakaCollection {
        $this->authorize('view', $paketKorisnika);

        $search = $request->get('search', '');

        $paketBiljakas = $paketKorisnika
            ->paketBiljakas()
            ->search($search)
            ->latest()
            ->paginate();

        return new PaketBiljakaCollection($paketBiljakas);
    }

    public function store(
        Request $request,
        PaketKorisnika $paketKorisnika
    ): PaketBiljakaResource {
        $this->authorize('create', PaketBiljaka::class);

        $validated = $request->validate([
            'biljkaPoljoprivrednikaID' => [
                'required',
                'exists:biljka_poljoprivrednikas,IDbiljkaPoljoprivrednika',
            ],
            'kilaza' => ['nullable', 'numeric'],
        ]);

        $paketBiljaka = $paketKorisnika->paketBiljakas()->create($validated);

        return new PaketBiljakaResource($paketBiljaka);
    }
}
