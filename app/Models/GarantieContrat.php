<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GarantieContrat extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'prime',
        'capital',
        'garantie_id',
        'contrat_id',
        'produit_id'
    ];
}
