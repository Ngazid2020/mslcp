<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Patient extends Model
{
    /** @use HasFactory<\Database\Factories\PatientFactory> */
    use HasFactory, SoftDeletes, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('patients');
    }

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

    public function bilanUrinaires()
    {
        return $this->hasMany(BilanUrinaire::class);
    }

    public function bacteriologies()
    {
        return $this->hasMany(Bacteriologie::class);
    }
}
