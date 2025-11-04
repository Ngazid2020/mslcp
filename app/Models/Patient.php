<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    /** @use HasFactory<\Database\Factories\PatientFactory> */
    use HasFactory;

    protected $fillable = [
        'numero',
        'nom',
        'prenom',
        'tel',
        'age',
        'sexe',
        'domicile',
        'lieu_naissance',
        'prescripteur_id',
    ];

    public function bilans()
    {
        return $this->hasMany(Bilan::class);
    }
}
