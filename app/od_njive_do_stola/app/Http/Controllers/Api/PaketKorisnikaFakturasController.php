<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\PaketKorisnika;
use App\Http\Controllers\Controller;
use App\Http\Resources\FakturaResource;
use App\Http\Resources\FakturaCollection;

class PaketKorisnikaFakturasController extends Controller
{
    public function index(
        Request $request,
        PaketKorisnika $paketKorisnika
    ): FakturaCollection {
        $this->authorize('view', $paketKorisnika);

        $search = $request->get('search', '');

        $fakturas = $paketKorisnika
            ->fakturas()
            ->search($search)
            ->latest()
            ->paginate();

        return new FakturaCollection($fakturas);
    }

    public function store(
        Request $request,
        PaketKorisnika $paketKorisnika
    ): FakturaResource {
        $this->authorize('create', Faktura::class);

        $validated = $request->validate([
            'cena' => ['required', 'numeric'],
            'tekstFakture' => ['nullable', 'max:255', 'string'],
            'placeno' => ['required', 'boolean'],
            'datumPlacanja' => ['nullable', 'date'],
        ]);

        $faktura = $paketKorisnika->fakturas()->create($validated);

        return new FakturaResource($faktura);
    }
}
