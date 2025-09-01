<?php

namespace App\Http\Controllers\Api;

use App\Models\TipPaketa;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\TipPaketaResource;
use App\Http\Resources\TipPaketaCollection;
use App\Http\Requests\TipPaketaStoreRequest;
use App\Http\Requests\TipPaketaUpdateRequest;

class TipPaketaController extends Controller
{
    public function index(Request $request): TipPaketaCollection
    {
        $this->authorize('view-any', TipPaketa::class);

        $search = $request->get('search', '');

        $tipPaketas = TipPaketa::search($search)
            ->latest()
            ->paginate();

        return new TipPaketaCollection($tipPaketas);
    }

    public function store(TipPaketaStoreRequest $request): TipPaketaResource
    {
        $this->authorize('create', TipPaketa::class);

        $validated = $request->validated();

        $tipPaketa = TipPaketa::create($validated);

        return new TipPaketaResource($tipPaketa);
    }

    public function show(
        Request $request,
        TipPaketa $tipPaketa
    ): TipPaketaResource {
        $this->authorize('view', $tipPaketa);

        return new TipPaketaResource($tipPaketa);
    }

    public function update(
        TipPaketaUpdateRequest $request,
        TipPaketa $tipPaketa
    ): TipPaketaResource {
        $this->authorize('update', $tipPaketa);

        $validated = $request->validated();

        $tipPaketa->update($validated);

        return new TipPaketaResource($tipPaketa);
    }

    public function destroy(Request $request, TipPaketa $tipPaketa): Response
    {
        $this->authorize('delete', $tipPaketa);

        $tipPaketa->delete();

        return response()->noContent();
    }
}
