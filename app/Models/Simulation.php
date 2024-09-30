<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simulation extends Model
{
    use HasFactory;

    protected $fillable = [
        'id','dateeche','datenaissance','duree','fraisacces','periodicite','differe','traite','primetotale','agence_id','produit_id'
    ];
}
