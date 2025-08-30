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
        'cenaGodisnjePretplate',
        'cenaMesecnePretplate',
        'opisPaketa',
        'nazivPaketa',
        'cenaRezervacije',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'tip_paketas';

    public $timestamps = false;

    public function paketKorisnikas()
    {
        return $this->hasMany(
            PaketKorisnika::class,
            'tipPaketaID',
            'IDtipPaketa'
        );
    }
}
