<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Models\Scopes\Searchable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use HasFactory;
    use Searchable;
    use HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'adresaDostave',
        'uputstvoZaDostavu',
        'brojTelefona',
        'postanskiBroj',
        'gradID',
        'is_admin',
        'poljoprivrednikID',
    ];

    protected $searchableFields = ['*'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

    public function gradkorisnika()
    {
        return $this->belongsTo(Grad::class, 'gradID', 'IDgrad');
    }

    public function poljoprivrednikKorisnika()
    {
        return $this->belongsTo(
            Poljoprivrednik::class,
            'poljoprivrednikID',
            'IDpoljoprivrednik'
        );
    }

    public function paketKorisnikas()
    {
        return $this->hasMany(PaketKorisnika::class, 'userID');
    }

    public function isSuperAdmin(): bool
    {
        return in_array($this->email, config('auth.super_admins'));
    }
}
