<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescripteur extends Model
{
    /** @use HasFactory<\Database\Factories\PrescripteurFactory> */
    use HasFactory;

    protected $fillable = [
        'nom',
        'adresse',
        'tel',
        'email',
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
