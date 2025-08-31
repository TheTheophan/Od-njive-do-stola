<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\PaketBiljaka;
use Illuminate\Http\Request;
use App\Models\PaketKorisnika;
use Illuminate\Http\RedirectResponse;
use App\Models\BiljkaPoljoprivrednika;
use App\Http\Requests\PaketBiljakaStoreRequest;
use App\Http\Requests\PaketBiljakaUpdateRequest;

class PaketBiljakaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', PaketBiljaka::class);

        $search = $request->get('search', '');

        $paketBiljakas = PaketBiljaka::search($search)
            ->latest('id')
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.paket_biljakas.index',
            compact('paketBiljakas', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', PaketBiljaka::class);

        $paketKorisnikas = PaketKorisnika::pluck('id', 'id');
        $biljkaPoljoprivrednikas = BiljkaPoljoprivrednika::pluck(
            'stanjeBiljke',
            'id'
        );

        return view(
            'app.paket_biljakas.create',
            compact('paketKorisnikas', 'biljkaPoljoprivrednikas')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaketBiljakaStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', PaketBiljaka::class);

        $validated = $request->validated();

        $paketBiljaka = PaketBiljaka::create($validated);

        return redirect()
            ->route('paket-biljakas.edit', $paketBiljaka)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, PaketBiljaka $paketBiljaka): View
    {
        $this->authorize('view', $paketBiljaka);

        return view('app.paket_biljakas.show', compact('paketBiljaka'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, PaketBiljaka $paketBiljaka): View
    {
        $this->authorize('update', $paketBiljaka);

        $paketKorisnikas = PaketKorisnika::pluck('id', 'id');
        $biljkaPoljoprivrednikas = BiljkaPoljoprivrednika::pluck(
            'stanjeBiljke',
            'id'
        );

        return view(
            'app.paket_biljakas.edit',
            compact(
                'paketBiljaka',
                'paketKorisnikas',
                'biljkaPoljoprivrednikas'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        PaketBiljakaUpdateRequest $request,
        PaketBiljaka $paketBiljaka
    ): RedirectResponse {
        $this->authorize('update', $paketBiljaka);

        $validated = $request->validated();

        $paketBiljaka->update($validated);

        return redirect()
            ->route('paket-biljakas.edit', $paketBiljaka)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        PaketBiljaka $paketBiljaka
    ): RedirectResponse {
        $this->authorize('delete', $paketBiljaka);

        $paketBiljaka->delete();

        return redirect()
            ->route('paket-biljakas.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
