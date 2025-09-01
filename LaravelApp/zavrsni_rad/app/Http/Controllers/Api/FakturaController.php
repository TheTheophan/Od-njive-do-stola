<?php

namespace App\Http\Controllers\Api;

use App\Models\Faktura;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\FakturaResource;
use App\Http\Resources\FakturaCollection;
use App\Http\Requests\FakturaStoreRequest;
use App\Http\Requests\FakturaUpdateRequest;

class FakturaController extends Controller
{
    public function index(Request $request): FakturaCollection
    {
        $this->authorize('view-any', Faktura::class);

        $search = $request->get('search', '');

        $fakturas = Faktura::search($search)
            ->latest()
            ->paginate();

        return new FakturaCollection($fakturas);
    }

    public function store(FakturaStoreRequest $request): FakturaResource
    {
        $this->authorize('create', Faktura::class);

        $validated = $request->validated();

        $faktura = Faktura::create($validated);

        return new FakturaResource($faktura);
    }

    public function show(Request $request, Faktura $faktura): FakturaResource
    {
        $this->authorize('view', $faktura);

        return new FakturaResource($faktura);
    }

    public function update(
        FakturaUpdateRequest $request,
        Faktura $faktura
    ): FakturaResource {
        $this->authorize('update', $faktura);

        $validated = $request->validated();

        $faktura->update($validated);

        return new FakturaResource($faktura);
    }

    public function destroy(Request $request, Faktura $faktura): Response
    {
        $this->authorize('delete', $faktura);

        $faktura->delete();

        return response()->noContent();
    }
}
