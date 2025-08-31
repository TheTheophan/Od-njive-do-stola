<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaketKorisnika extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['godisnjaPretplata', 'tipPaketaID', 'userID'];

    protected $searchableFields = ['*'];

    protected $table = 'paket_korisnikas';

    protected $casts = [
        'godisnjaPretplata' => 'boolean',
    ];

    public function userPaketKorisnika()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function tipPaketaPaketKorisnika()
    {
        return $this->belongsTo(TipPaketa::class, 'tipPaketaID');
    }

    public function fakturas()
    {
        return $this->hasMany(Faktura::class, 'paketKorisnikaID');
    }

    public function paketBiljakas()
    {
        return $this->hasMany(PaketBiljaka::class, 'paketKorisnikaID');
    }
}
