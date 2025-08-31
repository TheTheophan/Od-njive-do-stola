<?php

namespace App\Http\Controllers\Api;

use App\Models\Biljka;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\BiljkaResource;
use App\Http\Resources\BiljkaCollection;
use App\Http\Requests\BiljkaStoreRequest;
use App\Http\Requests\BiljkaUpdateRequest;

class BiljkaController extends Controller
{
    public function index(Request $request): BiljkaCollection
    {
        $this->authorize('view-any', Biljka::class);

        $search = $request->get('search', '');

        $biljkas = Biljka::search($search)
            ->latest('id')
            ->paginate();

        return new BiljkaCollection($biljkas);
    }

    public function store(BiljkaStoreRequest $request): BiljkaResource
    {
        $this->authorize('create', Biljka::class);

        $validated = $request->validated();

        $biljka = Biljka::create($validated);

        return new BiljkaResource($biljka);
    }

    public function show(Request $request, Biljka $biljka): BiljkaResource
    {
        $this->authorize('view', $biljka);

        return new BiljkaResource($biljka);
    }

    public function update(
        BiljkaUpdateRequest $request,
        Biljka $biljka
    ): BiljkaResource {
        $this->authorize('update', $biljka);

        $validated = $request->validated();

        $biljka->update($validated);

        return new BiljkaResource($biljka);
    }

    public function destroy(Request $request, Biljka $biljka): Response
    {
        $this->authorize('delete', $biljka);

        $biljka->delete();

        return response()->noContent();
    }
}
