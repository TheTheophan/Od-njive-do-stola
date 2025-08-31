<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use App\Models\TipPaketa;
use Illuminate\Http\Request;
use App\Models\PaketKorisnika;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\PaketKorisnikaStoreRequest;
use App\Http\Requests\PaketKorisnikaUpdateRequest;

class PaketKorisnikaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', PaketKorisnika::class);

        $search = $request->get('search', '');

        $paketKorisnikas = PaketKorisnika::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.paket_korisnikas.index',
            compact('paketKorisnikas', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', PaketKorisnika::class);

        $tipPaketas = TipPaketa::pluck('opisPaketa', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.paket_korisnikas.create',
            compact('tipPaketas', 'users')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaketKorisnikaStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', PaketKorisnika::class);

        $validated = $request->validated();

        $paketKorisnika = PaketKorisnika::create($validated);

        return redirect()
            ->route('paket-korisnikas.edit', $paketKorisnika)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, PaketKorisnika $paketKorisnika): View
    {
        $this->authorize('view', $paketKorisnika);

        return view('app.paket_korisnikas.show', compact('paketKorisnika'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, PaketKorisnika $paketKorisnika): View
    {
        $this->authorize('update', $paketKorisnika);

        $tipPaketas = TipPaketa::pluck('opisPaketa', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.paket_korisnikas.edit',
            compact('paketKorisnika', 'tipPaketas', 'users')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        PaketKorisnikaUpdateRequest $request,
        PaketKorisnika $paketKorisnika
    ): RedirectResponse {
        $this->authorize('update', $paketKorisnika);

        $validated = $request->validated();

        $paketKorisnika->update($validated);

        return redirect()
            ->route('paket-korisnikas.edit', $paketKorisnika)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        PaketKorisnika $paketKorisnika
    ): RedirectResponse {
        $this->authorize('delete', $paketKorisnika);

        $paketKorisnika->delete();

        return redirect()
            ->route('paket-korisnikas.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
