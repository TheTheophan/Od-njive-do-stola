<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Poljoprivrednik;
use App\Http\Controllers\Controller;
use App\Http\Resources\PoljoprivrednikResource;
use App\Http\Resources\PoljoprivrednikCollection;
use App\Http\Requests\PoljoprivrednikStoreRequest;
use App\Http\Requests\PoljoprivrednikUpdateRequest;

class PoljoprivrednikController extends Controller
{
    public function index(Request $request): PoljoprivrednikCollection
    {
        $this->authorize('view-any', Poljoprivrednik::class);

        $search = $request->get('search', '');

        $poljoprivredniks = Poljoprivrednik::search($search)
            ->latest()
            ->paginate();

        return new PoljoprivrednikCollection($poljoprivredniks);
    }

    public function store(
        PoljoprivrednikStoreRequest $request
    ): PoljoprivrednikResource {
        $this->authorize('create', Poljoprivrednik::class);

        $validated = $request->validated();

        $poljoprivrednik = Poljoprivrednik::create($validated);

        return new PoljoprivrednikResource($poljoprivrednik);
    }

    public function show(
        Request $request,
        Poljoprivrednik $poljoprivrednik
    ): PoljoprivrednikResource {
        $this->authorize('view', $poljoprivrednik);

        return new PoljoprivrednikResource($poljoprivrednik);
    }

    public function update(
        PoljoprivrednikUpdateRequest $request,
        Poljoprivrednik $poljoprivrednik
    ): PoljoprivrednikResource {
        $this->authorize('update', $poljoprivrednik);

        $validated = $request->validated();

        $poljoprivrednik->update($validated);

        return new PoljoprivrednikResource($poljoprivrednik);
    }

    public function destroy(
        Request $request,
        Poljoprivrednik $poljoprivrednik
    ): Response {
        $this->authorize('delete', $poljoprivrednik);

        $poljoprivrednik->delete();

        return response()->noContent();
    }
}
