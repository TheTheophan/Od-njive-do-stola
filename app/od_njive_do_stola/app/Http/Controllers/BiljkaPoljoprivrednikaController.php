<?php

namespace App\Http\Controllers;

use App\Models\Biljka;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Poljoprivrednik;
use Illuminate\Http\RedirectResponse;
use App\Models\BiljkaPoljoprivrednika;
use App\Http\Requests\BiljkaPoljoprivrednikaStoreRequest;
use App\Http\Requests\BiljkaPoljoprivrednikaUpdateRequest;

class BiljkaPoljoprivrednikaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', BiljkaPoljoprivrednika::class);

        $search = $request->get('search', '');

        $biljkaPoljoprivrednikas = BiljkaPoljoprivrednika::search($search)
            ->latest('id')
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.biljka_poljoprivrednikas.index',
            compact('biljkaPoljoprivrednikas', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', BiljkaPoljoprivrednika::class);

        $biljkas = Biljka::pluck('opisBiljke', 'id');
        $poljoprivredniks = Poljoprivrednik::pluck('adresa', 'id');

        return view(
            'app.biljka_poljoprivrednikas.create',
            compact('biljkas', 'poljoprivredniks')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        BiljkaPoljoprivrednikaStoreRequest $request
    ): RedirectResponse {
        $this->authorize('create', BiljkaPoljoprivrednika::class);

        $validated = $request->validated();

        $biljkaPoljoprivrednika = BiljkaPoljoprivrednika::create($validated);

        return redirect()
            ->route('biljka-poljoprivrednikas.edit', $biljkaPoljoprivrednika)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(
        Request $request,
        BiljkaPoljoprivrednika $biljkaPoljoprivrednika
    ): View {
        $this->authorize('view', $biljkaPoljoprivrednika);

        return view(
            'app.biljka_poljoprivrednikas.show',
            compact('biljkaPoljoprivrednika')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(
        Request $request,
        BiljkaPoljoprivrednika $biljkaPoljoprivrednika
    ): View {
        $this->authorize('update', $biljkaPoljoprivrednika);

        $biljkas = Biljka::pluck('opisBiljke', 'id');
        $poljoprivredniks = Poljoprivrednik::pluck('adresa', 'id');

        return view(
            'app.biljka_poljoprivrednikas.edit',
            compact('biljkaPoljoprivrednika', 'biljkas', 'poljoprivredniks')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        BiljkaPoljoprivrednikaUpdateRequest $request,
        BiljkaPoljoprivrednika $biljkaPoljoprivrednika
    ): RedirectResponse {
        $this->authorize('update', $biljkaPoljoprivrednika);

        $validated = $request->validated();

        $biljkaPoljoprivrednika->update($validated);

        return redirect()
            ->route('biljka-poljoprivrednikas.edit', $biljkaPoljoprivrednika)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        BiljkaPoljoprivrednika $biljkaPoljoprivrednika
    ): RedirectResponse {
        $this->authorize('delete', $biljkaPoljoprivrednika);

        $biljkaPoljoprivrednika->delete();

        return redirect()
            ->route('biljka-poljoprivrednikas.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
