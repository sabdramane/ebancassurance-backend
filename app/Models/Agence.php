<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agence extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'codeagence',
        'libeagence',
        'abrevagence',
        'adresse',
        'contact',
        'banque_id',
        'ville_id'
    ];

    public function banque()
    {
        return $this->belongsto(Banque::class);
    }

    public function ville()
    {
        return $this->belongsto(Ville::class);
    }

}
