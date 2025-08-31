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
            'godisnjaPretplata' => ['required', 'boolean'],
            'tipPaketaID' => ['required', 'exists:tip_paketas,IDtipPaketa'],
        ]);

        $paketKorisnika = $user->paketKorisnikas()->create($validated);

        return new PaketKorisnikaResource($paketKorisnika);
    }
}
