<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Faktura;
use Illuminate\Auth\Access\HandlesAuthorization;

class FakturaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the faktura can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the faktura can view the model.
     */
    public function view(User $user, Faktura $model): bool
    {
        return true;
    }

    /**
     * Determine whether the faktura can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the faktura can update the model.
     */
    public function update(User $user, Faktura $model): bool
    {
        return true;
    }

    /**
     * Determine whether the faktura can delete the model.
     */
    public function delete(User $user, Faktura $model): bool
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
     * Determine whether the faktura can restore the model.
     */
    public function restore(User $user, Faktura $model): bool
    {
        return false;
    }

    /**
     * Determine whether the faktura can permanently delete the model.
     */
    public function forceDelete(User $user, Faktura $model): bool
    {
        return false;
    }
}
