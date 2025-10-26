<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Faktura;
use Illuminate\Auth\Access\HandlesAuthorization;

class FakturaPolicy
{
    use HandlesAuthorization;

    
    public function viewAny(User $user): bool
    {
        return true;
    }

    
    public function view(User $user, Faktura $model): bool
    {
        return true;
    }

    
    public function create(User $user): bool
    {
        return true;
    }

    
    public function update(User $user, Faktura $model): bool
    {
        return true;
    }

    
    public function delete(User $user, Faktura $model): bool
    {
        return true;
    }

    
    public function deleteAny(User $user): bool
    {
        return true;
    }

    
    public function restore(User $user, Faktura $model): bool
    {
        return false;
    }

    
    public function forceDelete(User $user, Faktura $model): bool
    {
        return false;
    }
}
