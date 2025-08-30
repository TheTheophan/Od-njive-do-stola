<?php

namespace App\Policies;

use App\Models\Grad;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GradPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the grad can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the grad can view the model.
     */
    public function view(User $user, Grad $model): bool
    {
        return true;
    }

    /**
     * Determine whether the grad can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the grad can update the model.
     */
    public function update(User $user, Grad $model): bool
    {
        return true;
    }

    /**
     * Determine whether the grad can delete the model.
     */
    public function delete(User $user, Grad $model): bool
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
     * Determine whether the grad can restore the model.
     */
    public function restore(User $user, Grad $model): bool
    {
        return false;
    }

    /**
     * Determine whether the grad can permanently delete the model.
     */
    public function forceDelete(User $user, Grad $model): bool
    {
        return false;
    }
}
