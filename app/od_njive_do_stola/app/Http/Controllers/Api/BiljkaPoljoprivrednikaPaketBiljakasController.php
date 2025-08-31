<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BiljkaPoljoprivrednika;
use App\Http\Resources\PaketBiljakaResource;
use App\Http\Resources\PaketBiljakaCollection;

class BiljkaPoljoprivrednikaPaketBiljakasController extends Controller
{
    public function index(
        Request $request,
        BiljkaPoljoprivrednika $biljkaPoljoprivrednika
    ): PaketBiljakaCollection {
        $this->authorize('view', $biljkaPoljoprivrednika);

        $search = $request->get('search', '');

        $paketBiljakas = $biljkaPoljoprivrednika
            ->paketBiljakas()
            ->search($search)
            ->latest()
            ->paginate();

        return new PaketBiljakaCollection($paketBiljakas);
    }

    public function store(
        Request $request,
        BiljkaPoljoprivrednika $biljkaPoljoprivrednika
    ): PaketBiljakaResource {
        $this->authorize('create', PaketBiljaka::class);

        $validated = $request->validate([
            'paketKorisnikaID' => [
                'required',
                'exists:paket_korisnikas,IDpaketKorisnika',
            ],
            'kilaza' => ['nullable', 'numeric'],
        ]);

        $paketBiljaka = $biljkaPoljoprivrednika
            ->paketBiljakas()
            ->create($validated);

        return new PaketBiljakaResource($paketBiljaka);
    }
}
