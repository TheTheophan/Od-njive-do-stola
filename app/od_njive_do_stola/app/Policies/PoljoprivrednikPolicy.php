<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Poljoprivrednik;
use Illuminate\Auth\Access\HandlesAuthorization;

class PoljoprivrednikPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the poljoprivrednik can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the poljoprivrednik can view the model.
     */
    public function view(User $user, Poljoprivrednik $model): bool
    {
        return true;
    }

    /**
     * Determine whether the poljoprivrednik can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the poljoprivrednik can update the model.
     */
    public function update(User $user, Poljoprivrednik $model): bool
    {
        return true;
    }

    /**
     * Determine whether the poljoprivrednik can delete the model.
     */
    public function delete(User $user, Poljoprivrednik $model): bool
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
     * Determine whether the poljoprivrednik can restore the model.
     */
    public function restore(User $user, Poljoprivrednik $model): bool
    {
        return false;
    }

    /**
     * Determine whether the poljoprivrednik can permanently delete the model.
     */
    public function forceDelete(User $user, Poljoprivrednik $model): bool
    {
        return false;
    }
}
