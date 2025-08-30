<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Slika;
use Illuminate\Auth\Access\HandlesAuthorization;

class SlikaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the slika can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the slika can view the model.
     */
    public function view(User $user, Slika $model): bool
    {
        return true;
    }

    /**
     * Determine whether the slika can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the slika can update the model.
     */
    public function update(User $user, Slika $model): bool
    {
        return true;
    }

    /**
     * Determine whether the slika can delete the model.
     */
    public function delete(User $user, Slika $model): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the slika can restore the model.
     */
    public function restore(User $user, Slika $model): bool
    {
        return false;
    }

    /**
     * Determine whether the slika can permanently delete the model.
     */
    public function forceDelete(User $user, Slika $model): bool
    {
        return false;
    }
}
