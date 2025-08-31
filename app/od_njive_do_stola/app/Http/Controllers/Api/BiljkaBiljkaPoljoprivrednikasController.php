<?php

namespace App\Http\Controllers\Api;

use App\Models\Biljka;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BiljkaPoljoprivrednikaResource;
use App\Http\Resources\BiljkaPoljoprivrednikaCollection;

class BiljkaBiljkaPoljoprivrednikasController extends Controller
{
    public function index(
        Request $request,
        Biljka $biljka
    ): BiljkaPoljoprivrednikaCollection {
        $this->authorize('view', $biljka);

        $search = $request->get('search', '');

        $biljkaPoljoprivrednikas = $biljka
            ->biljkaPoljoprivrednikas()
            ->search($search)
            ->latest()
            ->paginate();

        return new BiljkaPoljoprivrednikaCollection($biljkaPoljoprivrednikas);
    }

    public function store(
        Request $request,
        Biljka $biljka
    ): BiljkaPoljoprivrednikaResource {
        $this->authorize('create', BiljkaPoljoprivrednika::class);

        $validated = $request->validate([
            'poljoprivrednikID' => [
                'required',
                'exists:poljoprivredniks,IDpoljoprivrednik',
            ],
            'minNedeljniPrinos' => ['nullable', 'numeric'],
            'stanjeBiljke' => ['nullable', 'max:255', 'string'],
        ]);

        $biljkaPoljoprivrednika = $biljka
            ->biljkaPoljoprivrednikas()
            ->create($validated);

        return new BiljkaPoljoprivrednikaResource($biljkaPoljoprivrednika);
    }
}
