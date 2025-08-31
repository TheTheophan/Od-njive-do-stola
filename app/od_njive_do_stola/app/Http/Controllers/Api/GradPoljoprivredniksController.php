<?php

namespace App\Http\Controllers\Api;

use App\Models\Grad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PoljoprivrednikResource;
use App\Http\Resources\PoljoprivrednikCollection;

class GradPoljoprivredniksController extends Controller
{
    public function index(
        Request $request,
        Grad $grad
    ): PoljoprivrednikCollection {
        $this->authorize('view', $grad);

        $search = $request->get('search', '');

        $poljoprivredniks = $grad
            ->poljoprivredniks()
            ->search($search)
            ->latest()
            ->paginate();

        return new PoljoprivrednikCollection($poljoprivredniks);
    }

    public function store(Request $request, Grad $grad): PoljoprivrednikResource
    {
        $this->authorize('create', Poljoprivrednik::class);

        $validated = $request->validate([
            'adresa' => ['required', 'max:100', 'string'],
            'ime' => ['required', 'max:59', 'string'],
            'prezime' => ['required', 'max:60', 'string'],
            'opisAdrese' => ['nullable', 'max:255', 'string'],
            'brojTelefona' => ['required', 'max:18', 'string'],
            'brojHektara' => ['required', 'numeric'],
            'brojGazdinstva' => ['required', 'max:12', 'string'],
            'plastenickaProizvodnja' => ['required', 'boolean'],
        ]);

        $poljoprivrednik = $grad->poljoprivredniks()->create($validated);

        return new PoljoprivrednikResource($poljoprivrednik);
    }
}
