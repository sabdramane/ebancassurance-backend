<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'codeprod',
        'libeprod',
        'descprod',
        'categorie_produit_id'
    ];

    public function produitgaranties()
    {
        return $this->hasMany(ProduitGarantie::class);
    }
}
