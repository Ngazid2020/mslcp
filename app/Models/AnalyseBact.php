<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AnalyseBact extends Pivot
{
    protected $fillable = [
        'resultat',
    ];
}
