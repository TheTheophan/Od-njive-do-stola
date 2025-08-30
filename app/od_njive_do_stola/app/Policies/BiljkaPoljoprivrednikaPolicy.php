<?php

namespace App\Policies;

use App\Models\User;
use App\Models\BiljkaPoljoprivrednika;
use Illuminate\Auth\Access\HandlesAuthorization;

class BiljkaPoljoprivrednikaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the biljkaPoljoprivrednika can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the biljkaPoljoprivrednika can view the model.
     */
    public function view(User $user, BiljkaPoljoprivrednika $model): bool
    {
        return true;
    }

    /**
     * Determine whether the biljkaPoljoprivrednika can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the biljkaPoljoprivrednika can update the model.
     */
    public function update(User $user, BiljkaPoljoprivrednika $model): bool
    {
        return true;
    }

    /**
     * Determine whether the biljkaPoljoprivrednika can delete the model.
     */
    public function delete(User $user, BiljkaPoljoprivrednika $model): bool
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
     * Determine whether the biljkaPoljoprivrednika can restore the model.
     */
    public function restore(User $user, BiljkaPoljoprivrednika $model): bool
    {
        return false;
    }

    /**
     * Determine whether the biljkaPoljoprivrednika can permanently delete the model.
     */
    public function forceDelete(User $user, BiljkaPoljoprivrednika $model): bool
    {
        return false;
    }
}
