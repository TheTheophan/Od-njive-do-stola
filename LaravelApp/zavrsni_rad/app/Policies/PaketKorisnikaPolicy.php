<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PaketKorisnika;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaketKorisnikaPolicy
{
    use HandlesAuthorization;

    
    public function viewAny(User $user): bool
    {
        return true;
    }

    
    public function view(User $user, PaketKorisnika $model): bool
    {
        return true;
    }

    
    public function create(User $user): bool
    {
        return true;
    }

    
    public function update(User $user, PaketKorisnika $model): bool
    {
        return true;
    }

    
    public function delete(User $user, PaketKorisnika $model): bool
    {
        return $user->email === 'admin@admin.com';
    }

    
    public function deleteAny(User $user): bool
    {
        return $user->email === 'admin@admin.com';
    }

    
    public function restore(User $user, PaketKorisnika $model): bool
    {
        return false;
    }

    
    public function forceDelete(User $user, PaketKorisnika $model): bool
    {
        return false;
    }
}
