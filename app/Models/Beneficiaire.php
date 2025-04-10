<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'beneficiaire_nom',
        'telephone',
        'adresse',
        'ville',
        'typebeneficiaire'
    ];
}
