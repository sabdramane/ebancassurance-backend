<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'id','nom','prenom','telephone','dateNaissance','genre','profession','lieuNaissance','email','boitepostale','numcompte','clerib','codeagence','agence_id'
    ];
}
