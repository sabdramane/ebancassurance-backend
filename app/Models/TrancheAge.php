<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrancheAge extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'libelle',
        'age_min',
        'age_max'
    ];
}
