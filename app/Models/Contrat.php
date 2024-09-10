<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    use HasFactory;

    protected $fillable = [
        'id','numprojet','dateeffet','dateeche','datesaisie','duree','periodicite','differe','traite',
            'etat','fraisacces','primetotale','produit_id','agence_id','client_id','rapprochement_id'
    ];
}
