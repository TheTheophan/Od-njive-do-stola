<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\BiljkaPoljoprivrednika;
use App\Http\Resources\BiljkaPoljoprivrednikaResource;
use App\Http\Resources\BiljkaPoljoprivrednikaCollection;
use App\Http\Requests\BiljkaPoljoprivrednikaStoreRequest;
use App\Http\Requests\BiljkaPoljoprivrednikaUpdateRequest;

class BiljkaPoljoprivrednikaController extends Controller
{
    public function index(Request $request): BiljkaPoljoprivrednikaCollection
    {
        $this->authorize('view-any', BiljkaPoljoprivrednika::class);

        $search = $request->get('search', '');

        $biljkaPoljoprivrednikas = BiljkaPoljoprivrednika::search($search)
            ->latest('id')
            ->paginate();

        return new BiljkaPoljoprivrednikaCollection($biljkaPoljoprivrednikas);
    }

    public function store(
        BiljkaPoljoprivrednikaStoreRequest $request
    ): BiljkaPoljoprivrednikaResource {
        $this->authorize('create', BiljkaPoljoprivrednika::class);

        $validated = $request->validated();

        $biljkaPoljoprivrednika = BiljkaPoljoprivrednika::create($validated);

        return new BiljkaPoljoprivrednikaResource($biljkaPoljoprivrednika);
    }

    public function show(
        Request $request,
        BiljkaPoljoprivrednika $biljkaPoljoprivrednika
    ): BiljkaPoljoprivrednikaResource {
        $this->authorize('view', $biljkaPoljoprivrednika);

        return new BiljkaPoljoprivrednikaResource($biljkaPoljoprivrednika);
    }

    public function update(
        BiljkaPoljoprivrednikaUpdateRequest $request,
        BiljkaPoljoprivrednika $biljkaPoljoprivrednika
    ): BiljkaPoljoprivrednikaResource {
        $this->authorize('update', $biljkaPoljoprivrednika);

        $validated = $request->validated();

        $biljkaPoljoprivrednika->update($validated);

        return new BiljkaPoljoprivrednikaResource($biljkaPoljoprivrednika);
    }

    public function destroy(
        Request $request,
        BiljkaPoljoprivrednika $biljkaPoljoprivrednika
    ): Response {
        $this->authorize('delete', $biljkaPoljoprivrednika);

        $biljkaPoljoprivrednika->delete();

        return response()->noContent();
    }
}
