<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreContratQuestionnaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'valeur',
        'motif',
        'datesurvenance',
        'precontrat_id',
        'questionnaire_medical_id'
    ];
}
