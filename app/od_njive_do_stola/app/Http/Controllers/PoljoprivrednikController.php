<?php

namespace App\Http\Controllers;

use App\Models\Grad;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Poljoprivrednik;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\PoljoprivrednikStoreRequest;
use App\Http\Requests\PoljoprivrednikUpdateRequest;

class PoljoprivrednikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Poljoprivrednik::class);

        $search = $request->get('search', '');

        $poljoprivredniks = Poljoprivrednik::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.poljoprivredniks.index',
            compact('poljoprivredniks', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Poljoprivrednik::class);

        $grads = Grad::pluck('nazivGrada', 'id');

        return view('app.poljoprivredniks.create', compact('grads'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        PoljoprivrednikStoreRequest $request
    ): RedirectResponse {
        $this->authorize('create', Poljoprivrednik::class);

        $validated = $request->validated();

        $poljoprivrednik = Poljoprivrednik::create($validated);

        return redirect()
            ->route('poljoprivredniks.edit', $poljoprivrednik)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(
        Request $request,
        Poljoprivrednik $poljoprivrednik
    ): View {
        $this->authorize('view', $poljoprivrednik);

        return view('app.poljoprivredniks.show', compact('poljoprivrednik'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(
        Request $request,
        Poljoprivrednik $poljoprivrednik
    ): View {
        $this->authorize('update', $poljoprivrednik);

        $grads = Grad::pluck('nazivGrada', 'id');

        return view(
            'app.poljoprivredniks.edit',
            compact('poljoprivrednik', 'grads')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        PoljoprivrednikUpdateRequest $request,
        Poljoprivrednik $poljoprivrednik
    ): RedirectResponse {
        $this->authorize('update', $poljoprivrednik);

        $validated = $request->validated();

        $poljoprivrednik->update($validated);

        return redirect()
            ->route('poljoprivredniks.edit', $poljoprivrednik)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Poljoprivrednik $poljoprivrednik
    ): RedirectResponse {
        $this->authorize('delete', $poljoprivrednik);

        $poljoprivrednik->delete();

        return redirect()
            ->route('poljoprivredniks.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
