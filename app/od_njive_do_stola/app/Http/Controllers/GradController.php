<?php

namespace App\Http\Controllers;

use App\Models\Grad;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\GradStoreRequest;
use App\Http\Requests\GradUpdateRequest;

class GradController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Grad::class);

        $search = $request->get('search', '');

        $grads = Grad::search($search)
            ->latest('id')
            ->paginate(5)
            ->withQueryString();

        return view('app.grads.index', compact('grads', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Grad::class);

        return view('app.grads.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GradStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Grad::class);

        $validated = $request->validated();

        $grad = Grad::create($validated);

        return redirect()
            ->route('grads.edit', $grad)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Grad $grad): View
    {
        $this->authorize('view', $grad);

        return view('app.grads.show', compact('grad'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Grad $grad): View
    {
        $this->authorize('update', $grad);

        return view('app.grads.edit', compact('grad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        GradUpdateRequest $request,
        Grad $grad
    ): RedirectResponse {
        $this->authorize('update', $grad);

        $validated = $request->validated();

        $grad->update($validated);

        return redirect()
            ->route('grads.edit', $grad)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Grad $grad): RedirectResponse
    {
        $this->authorize('delete', $grad);

        $grad->delete();

        return redirect()
            ->route('grads.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
