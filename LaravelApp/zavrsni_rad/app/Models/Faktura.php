<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faktura extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['paket_korisnika_id', 'cena', 'tekst', 'placeno'];

    protected $searchableFields = ['*'];

    protected $casts = [
        'placeno' => 'boolean',
    ];

    public function paketKorisnika()
    {
        return $this->belongsTo(PaketKorisnika::class);
    }
}
