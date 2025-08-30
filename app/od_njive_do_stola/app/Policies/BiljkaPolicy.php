<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Biljka;
use Illuminate\Auth\Access\HandlesAuthorization;

class BiljkaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the biljka can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the biljka can view the model.
     */
    public function view(User $user, Biljka $model): bool
    {
        return true;
    }

    /**
     * Determine whether the biljka can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the biljka can update the model.
     */
    public function update(User $user, Biljka $model): bool
    {
        return true;
    }

    /**
     * Determine whether the biljka can delete the model.
     */
    public function delete(User $user, Biljka $model): bool
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
     * Determine whether the biljka can restore the model.
     */
    public function restore(User $user, Biljka $model): bool
    {
        return false;
    }

    /**
     * Determine whether the biljka can permanently delete the model.
     */
    public function forceDelete(User $user, Biljka $model): bool
    {
        return false;
    }
}
