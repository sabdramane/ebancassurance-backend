<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreContrat extends Model
{
    use HasFactory;

    protected $fillable = [
        'id','numprojet','dateeffet','dateeche','type_pret','datesaisie','duree_amort','duree_pret','periodicite','differe','montantpret','montant_traite',
            'capitalprevoyance','beogo','prime_nette_prevoyance','prime_perte_emploi','prime_beogo','etat','cout_police','primetotale','produit_id','agence_id','client_id','rapprochement_id','banque_id'
    ];
}
