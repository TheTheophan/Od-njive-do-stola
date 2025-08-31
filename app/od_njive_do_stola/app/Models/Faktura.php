<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faktura extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'paketKorisnikaID',
        'cena',
        'tekstFakture',
        'placeno',
        'datumPlacanja',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'placeno' => 'boolean',
        'datumPlacanja' => 'datetime',
    ];

    public function paketKorisnikaFaktura()
    {
        return $this->belongsTo(PaketKorisnika::class, 'paketKorisnikaID');
    }
}
