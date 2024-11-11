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
            ,'contrat_travail','contrat_travail_ext','employeur','beneficiaire_id'
    ];

    public function banque(){
        return $this->belongsto(Banque::class);
    }

    public function agence(){
        return $this->belongsto(Agence::class);
    }

    public function client(){
        return $this->belongsto(Client::class);
    }


}
