<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContratQuestionnaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'id','valeur','description','datesurvenance','contrat_id','questionnaire_medical_id'
    ];
}
