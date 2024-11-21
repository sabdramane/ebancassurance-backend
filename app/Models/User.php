<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'etat',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role(){
        return $this->belongsto(Role::class);
    }

     /**
     * Relation : Un utilisateur a une affectation.
     * La date de désaffectation est définie comme `null` par défaut.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function affectation()
    {
        return $this->hasOne(AgenceUser::class, 'user_id')
            ->whereNull('date_desaffectation'); // Filtre pour obtenir uniquement les affectations actives
    }

    /**
     * Définit l'ID utilisateur pour une affectation.
     *
     * @param \App\Models\AgenceUser $affectation
     * @return void
     */
    public function assignAffectation(AgenceUser $affectation)
    {
        $affectation->user_id = $this->id; // Associe l'utilisateur courant à l'affectation
        $affectation->date_desaffectation = null; // Définit la désaffectation comme null
        $affectation->save(); // Enregistre les modifications
    }


}
