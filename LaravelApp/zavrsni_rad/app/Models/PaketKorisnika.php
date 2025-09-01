<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaketKorisnika extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'godisnja_pretplata',
        'tip_paketa_id',
        'user_id',
        'adresa',
        'uputstvo_za_dostavu',
        'broj_telefona',
        'postanski_broj',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'paket_korisnikas';

    protected $casts = [
        'godisnja_pretplata' => 'boolean',
    ];

    public function tipPaketa()
    {
        return $this->belongsTo(TipPaketa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fakturas()
    {
        return $this->hasMany(Faktura::class);
    }
}
