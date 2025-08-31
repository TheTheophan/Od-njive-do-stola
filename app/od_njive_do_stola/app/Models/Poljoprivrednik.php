<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Poljoprivrednik extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'adresa',
        'ime',
        'prezime',
        'gradID',
        'opisAdrese',
        'brojTelefona',
        'brojHektara',
        'brojGazdinstva',
        'plastenickaProizvodnja',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'plastenickaProizvodnja' => 'boolean',
    ];

    public function gradpoljoprivrednika()
    {
        return $this->belongsTo(Grad::class, 'gradID');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'poljoprivrednikID');
    }

    public function biljkaPoljoprivrednikas()
    {
        return $this->hasMany(
            BiljkaPoljoprivrednika::class,
            'poljoprivrednikID'
        );
    }

    public function slikas()
    {
        return $this->hasMany(Slika::class, 'poljoprivrednikID');
    }
}
