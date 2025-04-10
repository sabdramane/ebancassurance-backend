<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BanqueGarantieTarif extends Model
{
    use HasFactory;

    public function garantie()
    {
        return $this->belongsto(Garantie::class);
    }
    public function produit()
    {
        return $this->belongsto(Produit::class);
    }

    public function banque()
    {
        return $this->belongsto(Banque::class);
    }
    public function tarif()
    {
        return $this->belongsto(Tarif::class);
    }
}
