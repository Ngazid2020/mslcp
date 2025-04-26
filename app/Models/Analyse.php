<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Analyse extends Pivot
{
    /** @use HasFactory<\Database\Factories\AnalyseFactory> */
    use HasFactory;

    protected $fillable = [
        'resultat',
    ];
}
