<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Poljoprivrednik;
use App\Http\Controllers\Controller;
use App\Http\Resources\SlikaResource;
use App\Http\Resources\SlikaCollection;

class PoljoprivrednikSlikasController extends Controller
{
    public function index(
        Request $request,
        Poljoprivrednik $poljoprivrednik
    ): SlikaCollection {
        $this->authorize('view', $poljoprivrednik);

        $search = $request->get('search', '');

        $slikas = $poljoprivrednik
            ->slikas()
            ->search($search)
            ->latest()
            ->paginate();

        return new SlikaCollection($slikas);
    }

    public function store(
        Request $request,
        Poljoprivrednik $poljoprivrednik
    ): SlikaResource {
        $this->authorize('create', Slika::class);

        $validated = $request->validate([
            'upotrebaSlike' => ['nullable', 'max:100', 'string'],
            'nazivDatoteke' => ['required', 'max:255', 'string'],
            'slika' => ['nullable', 'max:255'],
        ]);

        $slika = $poljoprivrednik->slikas()->create($validated);

        return new SlikaResource($slika);
    }
}
