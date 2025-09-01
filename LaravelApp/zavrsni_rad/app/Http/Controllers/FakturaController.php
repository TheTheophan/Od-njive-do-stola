<?php

namespace App\Http\Controllers;

use App\Models\Faktura;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\PaketKorisnika;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\FakturaStoreRequest;
use App\Http\Requests\FakturaUpdateRequest;

class FakturaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Faktura::class);

        $search = $request->get('search', '');

        $fakturas = Faktura::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.fakturas.index', compact('fakturas', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Faktura::class);

        $paketKorisnikas = PaketKorisnika::pluck('adresa', 'id');

        return view('app.fakturas.create', compact('paketKorisnikas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FakturaStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Faktura::class);

        $validated = $request->validated();

        $faktura = Faktura::create($validated);

        return redirect()
            ->route('fakturas.edit', $faktura)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Faktura $faktura): View
    {
        $this->authorize('view', $faktura);

        return view('app.fakturas.show', compact('faktura'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Faktura $faktura): View
    {
        $this->authorize('update', $faktura);

        $paketKorisnikas = PaketKorisnika::pluck('adresa', 'id');

        return view('app.fakturas.edit', compact('faktura', 'paketKorisnikas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        FakturaUpdateRequest $request,
        Faktura $faktura
    ): RedirectResponse {
        $this->authorize('update', $faktura);

        $validated = $request->validated();

        $faktura->update($validated);

        return redirect()
            ->route('fakturas.edit', $faktura)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Faktura $faktura
    ): RedirectResponse {
        $this->authorize('delete', $faktura);

        $faktura->delete();

        return redirect()
            ->route('fakturas.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
