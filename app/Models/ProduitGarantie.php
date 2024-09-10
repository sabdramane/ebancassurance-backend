<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduitGarantie extends Model
{
    use HasFactory;

    public function produit(){
        return $this->belongsto(Banque::class);
    }

    public function garantie(){
        return $this->belongsto(Ville::class);
    }
}
