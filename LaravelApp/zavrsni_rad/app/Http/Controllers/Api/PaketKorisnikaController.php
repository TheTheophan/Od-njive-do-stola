<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\PaketKorisnika;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaketKorisnikaResource;
use App\Http\Resources\PaketKorisnikaCollection;
use App\Http\Requests\PaketKorisnikaStoreRequest;
use App\Http\Requests\PaketKorisnikaUpdateRequest;

class PaketKorisnikaController extends Controller
{
    public function index(Request $request): PaketKorisnikaCollection
    {
        $this->authorize('view-any', PaketKorisnika::class);

        $search = $request->get('search', '');

        $paketKorisnikas = PaketKorisnika::search($search)
            ->latest()
            ->paginate();

        return new PaketKorisnikaCollection($paketKorisnikas);
    }

    public function store(
        PaketKorisnikaStoreRequest $request
    ): PaketKorisnikaResource {
        $this->authorize('create', PaketKorisnika::class);

        $validated = $request->validated();

        $paketKorisnika = PaketKorisnika::create($validated);

        return new PaketKorisnikaResource($paketKorisnika);
    }

    public function show(
        Request $request,
        PaketKorisnika $paketKorisnika
    ): PaketKorisnikaResource {
        $this->authorize('view', $paketKorisnika);

        return new PaketKorisnikaResource($paketKorisnika);
    }

    public function update(
        PaketKorisnikaUpdateRequest $request,
        PaketKorisnika $paketKorisnika
    ): PaketKorisnikaResource {
        $this->authorize('update', $paketKorisnika);

        $validated = $request->validated();

        $paketKorisnika->update($validated);

        return new PaketKorisnikaResource($paketKorisnika);
    }

    public function destroy(
        Request $request,
        PaketKorisnika $paketKorisnika
    ): Response {
        $this->authorize('delete', $paketKorisnika);

        $paketKorisnika->delete();

        return response()->noContent();
    }
}
