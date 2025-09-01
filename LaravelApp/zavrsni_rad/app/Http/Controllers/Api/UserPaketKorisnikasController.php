<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaketKorisnikaResource;
use App\Http\Resources\PaketKorisnikaCollection;

class UserPaketKorisnikasController extends Controller
{
    public function index(
        Request $request,
        User $user
    ): PaketKorisnikaCollection {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $paketKorisnikas = $user
            ->paketKorisnikas()
            ->search($search)
            ->latest()
            ->paginate();

        return new PaketKorisnikaCollection($paketKorisnikas);
    }

    public function store(Request $request, User $user): PaketKorisnikaResource
    {
        $this->authorize('create', PaketKorisnika::class);

        $validated = $request->validate([
            'godisnja_pretplata' => ['required', 'boolean'],
            'tip_paketa_id' => ['required', 'exists:tip_paketas,id'],
            'adresa' => ['required', 'max:254', 'string'],
            'uputstvo_za_dostavu' => ['nullable', 'max:254', 'string'],
            'broj_telefona' => ['nullable', 'max:18', 'string'],
            'postanski_broj' => ['nullable', 'max:20', 'string'],
        ]);

        $paketKorisnika = $user->paketKorisnikas()->create($validated);

        return new PaketKorisnikaResource($paketKorisnika);
    }
}
