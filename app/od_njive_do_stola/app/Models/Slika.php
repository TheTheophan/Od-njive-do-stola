<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slika extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'upotrebaSlike',
        'nazivDatoteke',
        'slika',
        'poljoprivrednikID',
    ];

    protected $searchableFields = ['*'];

    public function poljoprivrednikSlika()
    {
        return $this->belongsTo(Poljoprivrednik::class, 'poljoprivrednikID');
    }
}
