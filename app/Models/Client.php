<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'id','codeagence','numcompte','clerib','nom','prenom','telephone','dateNaissance','civilite','profession','lieuNaissance','email','boitepostale','adresse','ville'
    ];
}
