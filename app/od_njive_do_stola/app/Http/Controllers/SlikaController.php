<?php

namespace App\Http\Controllers;

use App\Models\Slika;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Poljoprivrednik;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\SlikaStoreRequest;
use App\Http\Requests\SlikaUpdateRequest;

class SlikaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Slika::class);

        $search = $request->get('search', '');

        $slikas = Slika::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.slikas.index', compact('slikas', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Slika::class);

        $poljoprivredniks = Poljoprivrednik::pluck('adresa', 'id');

        return view('app.slikas.create', compact('poljoprivredniks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SlikaStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Slika::class);

        $validated = $request->validated();

        $slika = Slika::create($validated);

        return redirect()
            ->route('slikas.edit', $slika)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Slika $slika): View
    {
        $this->authorize('view', $slika);

        return view('app.slikas.show', compact('slika'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Slika $slika): View
    {
        $this->authorize('update', $slika);

        $poljoprivredniks = Poljoprivrednik::pluck('adresa', 'id');

        return view('app.slikas.edit', compact('slika', 'poljoprivredniks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        SlikaUpdateRequest $request,
        Slika $slika
    ): RedirectResponse {
        $this->authorize('update', $slika);

        $validated = $request->validated();

        $slika->update($validated);

        return redirect()
            ->route('slikas.edit', $slika)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Slika $slika): RedirectResponse
    {
        $this->authorize('delete', $slika);

        $slika->delete();

        return redirect()
            ->route('slikas.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
