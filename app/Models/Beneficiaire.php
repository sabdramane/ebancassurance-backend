<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'id','nom','prenom','telephone','adresse','ville','typebeneficiaire','client_id','contrat_id'
    ];
}
