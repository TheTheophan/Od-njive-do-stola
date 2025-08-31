<?php

namespace App\Http\Controllers\Api;

use App\Models\Slika;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\SlikaResource;
use App\Http\Resources\SlikaCollection;
use App\Http\Requests\SlikaStoreRequest;
use App\Http\Requests\SlikaUpdateRequest;

class SlikaController extends Controller
{
    public function index(Request $request): SlikaCollection
    {
        $this->authorize('view-any', Slika::class);

        $search = $request->get('search', '');

        $slikas = Slika::search($search)
            ->latest()
            ->paginate();

        return new SlikaCollection($slikas);
    }

    public function store(SlikaStoreRequest $request): SlikaResource
    {
        $this->authorize('create', Slika::class);

        $validated = $request->validated();

        $slika = Slika::create($validated);

        return new SlikaResource($slika);
    }

    public function show(Request $request, Slika $slika): SlikaResource
    {
        $this->authorize('view', $slika);

        return new SlikaResource($slika);
    }

    public function update(
        SlikaUpdateRequest $request,
        Slika $slika
    ): SlikaResource {
        $this->authorize('update', $slika);

        $validated = $request->validated();

        $slika->update($validated);

        return new SlikaResource($slika);
    }

    public function destroy(Request $request, Slika $slika): Response
    {
        $this->authorize('delete', $slika);

        $slika->delete();

        return response()->noContent();
    }
}
