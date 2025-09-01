<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipPaketa extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'cena_godisnje_pretplate',
        'cena_mesecne_pretplate',
        'opis',
        'naziv',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'tip_paketas';

    public function paketKorisnikas()
    {
        return $this->hasMany(PaketKorisnika::class);
    }
}
