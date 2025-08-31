<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Poljoprivrednik;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;

class PoljoprivrednikUsersController extends Controller
{
    public function index(
        Request $request,
        Poljoprivrednik $poljoprivrednik
    ): UserCollection {
        $this->authorize('view', $poljoprivrednik);

        $search = $request->get('search', '');

        $users = $poljoprivrednik
            ->users()
            ->search($search)
            ->latest()
            ->paginate();

        return new UserCollection($users);
    }

    public function store(
        Request $request,
        Poljoprivrednik $poljoprivrednik
    ): UserResource {
        $this->authorize('create', User::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'email' => ['required', 'unique:users,email', 'email'],
            'password' => ['required'],
            'adresaDostave' => ['nullable', 'max:100', 'string'],
            'uputstvoZaDostavu' => ['nullable', 'max:255', 'string'],
            'brojTelefona' => ['required', 'max:18', 'string'],
            'postanskiBroj' => ['required', 'max:20', 'string'],
            'gradID' => ['required', 'exists:grads,IDgrad'],
            'is_admin' => ['required', 'boolean'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = $poljoprivrednik->users()->create($validated);

        return new UserResource($user);
    }
}
