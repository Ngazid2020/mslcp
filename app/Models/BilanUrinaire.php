<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BilanUrinaire extends Model
{
    protected $fillable = [
        'patient_id',
        'prescripteur_id',
        'urobilinogene',
        'albumine',
        'sucre',
        'acetone',
        'ph',
        'bilirubine',
        'densite',
        'sang',
        'nitrite',
        'leucocytes',
        'aspect_urines',
        'cellules_epitheliales',
        'leucocytes_micro',
        'hematies',
        'parasites',
        'elements_fongiques',
        'bacteries',
        'cristaux',
        'coloration_gram',
        'culture',
        'conclusion',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function prescripteur()
    {
        return $this->belongsTo(Prescripteur::class);
    }
}
