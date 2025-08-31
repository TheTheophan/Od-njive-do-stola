<?php

namespace App\Http\Controllers\Api;

use App\Models\Grad;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;

class GradUsersController extends Controller
{
    public function index(Request $request, Grad $grad): UserCollection
    {
        $this->authorize('view', $grad);

        $search = $request->get('search', '');

        $users = $grad
            ->users()
            ->search($search)
            ->latest()
            ->paginate();

        return new UserCollection($users);
    }

    public function store(Request $request, Grad $grad): UserResource
    {
        $this->authorize('create', User::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'email' => ['required', 'unique:users,email', 'email'],
            'password' => ['required'],
            'adresaDostave' => ['nullable', 'max:100', 'string'],
            'uputstvoZaDostavu' => ['nullable', 'max:255', 'string'],
            'brojTelefona' => ['required', 'max:18', 'string'],
            'postanskiBroj' => ['required', 'max:20', 'string'],
            'is_admin' => ['required', 'boolean'],
            'poljoprivrednikID' => [
                'required',
                'exists:poljoprivredniks,IDpoljoprivrednik',
            ],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = $grad->users()->create($validated);

        return new UserResource($user);
    }
}
