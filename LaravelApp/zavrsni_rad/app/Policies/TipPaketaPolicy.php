<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TipPaketa;
use Illuminate\Auth\Access\HandlesAuthorization;

class TipPaketaPolicy
{
    use HandlesAuthorization;

    
    public function viewAny(User $user): bool
    {
        return true;
    }

    
    public function view(User $user, TipPaketa $model): bool
    {
        return true;
    }

    
    public function create(User $user): bool
    {
        return true;
    }

    
    public function update(User $user, TipPaketa $model): bool
    {
        return true;
    }

    
    public function delete(User $user, TipPaketa $model): bool
    {
        return true;
    }

   
    public function deleteAny(User $user): bool
    {
        return true;
    }

    
    public function restore(User $user, TipPaketa $model): bool
    {
        return false;
    }

    
    public function forceDelete(User $user, TipPaketa $model): bool
    {
        return false;
    }
}
