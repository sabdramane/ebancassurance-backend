<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BanqueProduit extends Model
{
    use HasFactory;

    public function produit(){
        return $this->belongsto(Produit::class);
    }

    public function banque(){
        return $this->belongsto(Banque::class);
    }
}
