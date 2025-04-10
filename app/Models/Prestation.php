<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestation extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'client_id',
        'type_prestation_id',
        'date_declaration',
        'date_survenance',
        'etat',
        'declaration',
        'contrat_assurance',
        'piece_identite',
        'tableau_amortissement',
        'acte_deces',
        'certificat_deces',
        'acte_licenciement',
        'certificat_travail',
        'invalidite'
    ];

    public function client()
    {
        return $this->belongsto(Client::class);
    }
    public function typePrestation()
    {
        return $this->belongsto(TypePrestation::class);
    }

    public function commentaires()
    {
        return $this->belongsToMany(Commentaire::class);
    }
    public function piecejointes()
    {
        return $this->belongsToMany(PieceJointe::class);
    }
}
