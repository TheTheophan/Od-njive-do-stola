<?php

namespace App\Http\Controllers;

use App\Models\Biljka;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\BiljkaStoreRequest;
use App\Http\Requests\BiljkaUpdateRequest;

class BiljkaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Biljka::class);

        $search = $request->get('search', '');

        $biljkas = Biljka::search($search)
            ->latest('id')
            ->paginate(5)
            ->withQueryString();

        return view('app.biljkas.index', compact('biljkas', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Biljka::class);

        return view('app.biljkas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BiljkaStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Biljka::class);

        $validated = $request->validated();

        $biljka = Biljka::create($validated);

        return redirect()
            ->route('biljkas.edit', $biljka)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Biljka $biljka): View
    {
        $this->authorize('view', $biljka);

        return view('app.biljkas.show', compact('biljka'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Biljka $biljka): View
    {
        $this->authorize('update', $biljka);

        return view('app.biljkas.edit', compact('biljka'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        BiljkaUpdateRequest $request,
        Biljka $biljka
    ): RedirectResponse {
        $this->authorize('update', $biljka);

        $validated = $request->validated();

        $biljka->update($validated);

        return redirect()
            ->route('biljkas.edit', $biljka)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Biljka $biljka): RedirectResponse
    {
        $this->authorize('delete', $biljka);

        $biljka->delete();

        return redirect()
            ->route('biljkas.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
