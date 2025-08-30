<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PaketBiljaka;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaketBiljakaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the paketBiljaka can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the paketBiljaka can view the model.
     */
    public function view(User $user, PaketBiljaka $model): bool
    {
        return true;
    }

    /**
     * Determine whether the paketBiljaka can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the paketBiljaka can update the model.
     */
    public function update(User $user, PaketBiljaka $model): bool
    {
        return true;
    }

    /**
     * Determine whether the paketBiljaka can delete the model.
     */
    public function delete(User $user, PaketBiljaka $model): bool
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
     * Determine whether the paketBiljaka can restore the model.
     */
    public function restore(User $user, PaketBiljaka $model): bool
    {
        return false;
    }

    /**
     * Determine whether the paketBiljaka can permanently delete the model.
     */
    public function forceDelete(User $user, PaketBiljaka $model): bool
    {
        return false;
    }
}
