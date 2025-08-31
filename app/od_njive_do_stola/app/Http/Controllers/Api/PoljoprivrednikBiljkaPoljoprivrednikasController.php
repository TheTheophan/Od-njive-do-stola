<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Poljoprivrednik;
use App\Http\Controllers\Controller;
use App\Http\Resources\BiljkaPoljoprivrednikaResource;
use App\Http\Resources\BiljkaPoljoprivrednikaCollection;

class PoljoprivrednikBiljkaPoljoprivrednikasController extends Controller
{
    public function index(
        Request $request,
        Poljoprivrednik $poljoprivrednik
    ): BiljkaPoljoprivrednikaCollection {
        $this->authorize('view', $poljoprivrednik);

        $search = $request->get('search', '');

        $biljkaPoljoprivrednikas = $poljoprivrednik
            ->biljkaPoljoprivrednikas()
            ->search($search)
            ->latest()
            ->paginate();

        return new BiljkaPoljoprivrednikaCollection($biljkaPoljoprivrednikas);
    }

    public function store(
        Request $request,
        Poljoprivrednik $poljoprivrednik
    ): BiljkaPoljoprivrednikaResource {
        $this->authorize('create', BiljkaPoljoprivrednika::class);

        $validated = $request->validate([
            'biljkaID' => ['required', 'exists:biljkas,IDbiljka'],
            'minNedeljniPrinos' => ['nullable', 'numeric'],
            'stanjeBiljke' => ['nullable', 'max:255', 'string'],
        ]);

        $biljkaPoljoprivrednika = $poljoprivrednik
            ->biljkaPoljoprivrednikas()
            ->create($validated);

        return new BiljkaPoljoprivrednikaResource($biljkaPoljoprivrednika);
    }
}
