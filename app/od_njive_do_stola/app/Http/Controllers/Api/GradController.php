<?php

namespace App\Http\Controllers\Api;

use App\Models\Grad;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\GradResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\GradCollection;
use App\Http\Requests\GradStoreRequest;
use App\Http\Requests\GradUpdateRequest;

class GradController extends Controller
{
    public function index(Request $request): GradCollection
    {
        $this->authorize('view-any', Grad::class);

        $search = $request->get('search', '');

        $grads = Grad::search($search)
            ->latest('id')
            ->paginate();

        return new GradCollection($grads);
    }

    public function store(GradStoreRequest $request): GradResource
    {
        $this->authorize('create', Grad::class);

        $validated = $request->validated();

        $grad = Grad::create($validated);

        return new GradResource($grad);
    }

    public function show(Request $request, Grad $grad): GradResource
    {
        $this->authorize('view', $grad);

        return new GradResource($grad);
    }

    public function update(GradUpdateRequest $request, Grad $grad): GradResource
    {
        $this->authorize('update', $grad);

        $validated = $request->validated();

        $grad->update($validated);

        return new GradResource($grad);
    }

    public function destroy(Request $request, Grad $grad): Response
    {
        $this->authorize('delete', $grad);

        $grad->delete();

        return response()->noContent();
    }
}
