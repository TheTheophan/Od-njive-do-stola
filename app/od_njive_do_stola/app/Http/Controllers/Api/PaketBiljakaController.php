<?php

namespace App\Http\Controllers\Api;

use App\Models\PaketBiljaka;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaketBiljakaResource;
use App\Http\Resources\PaketBiljakaCollection;
use App\Http\Requests\PaketBiljakaStoreRequest;
use App\Http\Requests\PaketBiljakaUpdateRequest;

class PaketBiljakaController extends Controller
{
    public function index(Request $request): PaketBiljakaCollection
    {
        $this->authorize('view-any', PaketBiljaka::class);

        $search = $request->get('search', '');

        $paketBiljakas = PaketBiljaka::search($search)
            ->latest('id')
            ->paginate();

        return new PaketBiljakaCollection($paketBiljakas);
    }

    public function store(
        PaketBiljakaStoreRequest $request
    ): PaketBiljakaResource {
        $this->authorize('create', PaketBiljaka::class);

        $validated = $request->validated();

        $paketBiljaka = PaketBiljaka::create($validated);

        return new PaketBiljakaResource($paketBiljaka);
    }

    public function show(
        Request $request,
        PaketBiljaka $paketBiljaka
    ): PaketBiljakaResource {
        $this->authorize('view', $paketBiljaka);

        return new PaketBiljakaResource($paketBiljaka);
    }

    public function update(
        PaketBiljakaUpdateRequest $request,
        PaketBiljaka $paketBiljaka
    ): PaketBiljakaResource {
        $this->authorize('update', $paketBiljaka);

        $validated = $request->validated();

        $paketBiljaka->update($validated);

        return new PaketBiljakaResource($paketBiljaka);
    }

    public function destroy(
        Request $request,
        PaketBiljaka $paketBiljaka
    ): Response {
        $this->authorize('delete', $paketBiljaka);

        $paketBiljaka->delete();

        return response()->noContent();
    }
}
