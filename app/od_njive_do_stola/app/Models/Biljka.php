<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Biljka extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['opisBiljke', 'nazivBiljke', 'sezona'];

    protected $searchableFields = ['*'];

    public $timestamps = false;

    public function biljkaPoljoprivrednikas()
    {
        return $this->hasMany(
            BiljkaPoljoprivrednika::class,
            'biljkaID',
            'IDbiljka'
        );
    }
}
