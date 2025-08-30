<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaketBiljaka extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'paketKorisnikaID',
        'biljkaPoljoprivrednikaID',
        'kilaza',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'paket_biljakas';

    public $timestamps = false;

    public function biljkaPoljoprivrednikaPaketBiljaka()
    {
        return $this->belongsTo(
            BiljkaPoljoprivrednika::class,
            'biljkaPoljoprivrednikaID',
            'IDbiljkaPoljoprivrednika'
        );
    }

    public function paketKorisnikaPaketBiljaka()
    {
        return $this->belongsTo(
            PaketKorisnika::class,
            'paketKorisnikaID',
            'IDpaketKorisnika'
        );
    }
}
