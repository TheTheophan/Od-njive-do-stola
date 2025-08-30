<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BiljkaPoljoprivrednika extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'biljkaID',
        'poljoprivrednikID',
        'minNedeljniPrinos',
        'stanjeBiljke',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'biljka_poljoprivrednikas';

    public $timestamps = false;

    public function paketBiljakas()
    {
        return $this->hasMany(
            PaketBiljaka::class,
            'biljkaPoljoprivrednikaID',
            'IDbiljkaPoljoprivrednika'
        );
    }

    public function biljkaBiljkaPoljoprivrednika()
    {
        return $this->belongsTo(Biljka::class, 'biljkaID', 'IDbiljka');
    }

    public function poljoprivrednikBiljkaPoljoprivrednika()
    {
        return $this->belongsTo(
            Poljoprivrednik::class,
            'poljoprivrednikID',
            'IDpoljoprivrednik'
        );
    }
}
