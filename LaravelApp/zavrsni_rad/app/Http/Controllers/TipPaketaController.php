<?php

namespace App\Http\Controllers;

use App\Models\TipPaketa;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\TipPaketaStoreRequest;
use App\Http\Requests\TipPaketaUpdateRequest;

class TipPaketaController extends Controller
{
   
    public function index(Request $request): View
    {
        $this->authorize('view-any', TipPaketa::class);

        $search = $request->get('search', '');

        $tipPaketas = TipPaketa::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.tip_paketas.index', compact('tipPaketas', 'search'));
    }

    
    public function create(Request $request): View
    {
        $this->authorize('create', TipPaketa::class);

        return view('app.tip_paketas.create');
    }

    
    public function store(TipPaketaStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', TipPaketa::class);

        $validated = $request->validated();

        $tipPaketa = TipPaketa::create($validated);

        return redirect()
            ->route('tip-paketas.edit', $tipPaketa)
            ->withSuccess(__('crud.common.created'));
    }

    
    public function show(Request $request, TipPaketa $tipPaketa): View
    {
        $this->authorize('view', $tipPaketa);

        return view('app.tip_paketas.show', compact('tipPaketa'));
    }

    
    public function edit(Request $request, TipPaketa $tipPaketa): View
    {
        $this->authorize('update', $tipPaketa);

        return view('app.tip_paketas.edit', compact('tipPaketa'));
    }

    public function update(
        TipPaketaUpdateRequest $request,
        TipPaketa $tipPaketa
    ): RedirectResponse {
        $this->authorize('update', $tipPaketa);

        $validated = $request->validated();

        $tipPaketa->update($validated);

        return redirect()
            ->route('tip-paketas.edit', $tipPaketa)
            ->withSuccess(__('crud.common.saved'));
    }

    
    public function destroy(
        Request $request,
        TipPaketa $tipPaketa
    ): RedirectResponse {
        $this->authorize('delete', $tipPaketa);

        $tipPaketa->delete();

        return redirect()
            ->route('tip-paketas.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
