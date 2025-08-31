<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grad extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['nazivGrada'];

    protected $searchableFields = ['*'];

    public $timestamps = false;

    public function users()
    {
        return $this->hasMany(User::class, 'gradID');
    }

    public function poljoprivredniks()
    {
        return $this->hasMany(Poljoprivrednik::class, 'gradID');
    }
}
