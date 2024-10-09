<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapprochement extends Model
{
    use HasFactory;

    protected $fillable = [
        'id','daterapproch','datecompt','montant','datedebut','datefin'
    ];
}
