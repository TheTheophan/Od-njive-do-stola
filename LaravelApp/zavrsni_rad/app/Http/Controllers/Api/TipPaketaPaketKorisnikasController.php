<?php

namespace App\Http\Controllers\Api;

use App\Models\TipPaketa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaketKorisnikaResource;
use App\Http\Resources\PaketKorisnikaCollection;

class TipPaketaPaketKorisnikasController extends Controller
{
    public function index(
        Request $request,
        TipPaketa $tipPaketa
    ): PaketKorisnikaCollection {
        $this->authorize('view', $tipPaketa);

        $search = $request->get('search', '');

        $paketKorisnikas = $tipPaketa
            ->paketKorisnikas()
            ->search($search)
            ->latest()
            ->paginate();

        return new PaketKorisnikaCollection($paketKorisnikas);
    }

    public function store(
        Request $request,
        TipPaketa $tipPaketa
    ): PaketKorisnikaResource {
        $this->authorize('create', PaketKorisnika::class);

        $validated = $request->validate([
            'godisnja_pretplata' => ['required', 'boolean'],
            'user_id' => ['required', 'exists:users,id'],
            'adresa' => ['required', 'max:254', 'string'],
            'uputstvo_za_dostavu' => ['nullable', 'max:254', 'string'],
            'broj_telefona' => ['nullable', 'max:18', 'string'],
            'postanski_broj' => ['nullable', 'max:20', 'string'],
        ]);

        $paketKorisnika = $tipPaketa->paketKorisnikas()->create($validated);

        return new PaketKorisnikaResource($paketKorisnika);
    }
}
