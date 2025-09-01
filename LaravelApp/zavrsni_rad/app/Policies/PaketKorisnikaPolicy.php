<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PaketKorisnika;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaketKorisnikaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the paketKorisnika can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the paketKorisnika can view the model.
     */
    public function view(User $user, PaketKorisnika $model): bool
    {
        return true;
    }

    /**
     * Determine whether the paketKorisnika can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the paketKorisnika can update the model.
     */
    public function update(User $user, PaketKorisnika $model): bool
    {
        return true;
    }

    /**
     * Determine whether the paketKorisnika can delete the model.
     */
    public function delete(User $user, PaketKorisnika $model): bool
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
     * Determine whether the paketKorisnika can restore the model.
     */
    public function restore(User $user, PaketKorisnika $model): bool
    {
        return false;
    }

    /**
     * Determine whether the paketKorisnika can permanently delete the model.
     */
    public function forceDelete(User $user, PaketKorisnika $model): bool
    {
        return false;
    }
}
