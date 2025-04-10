<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamenSouscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'categorie_produit_id',
        'examen_id',
        'tranche_age_id',
        'tranche_capital_id'
    ];
}
