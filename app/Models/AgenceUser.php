<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgenceUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'agence_id', 
        'user_id',
        'date_affectation'
    ];

    public function agence() {
        return $this->belongsTo('App\Models\Agence');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }


    protected $casts = [
        'date_affectation'=>'date:d-m-Y'
    ];

}
