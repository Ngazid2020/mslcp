<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Analyse extends Model
{
    /** @use HasFactory<\Database\Factories\AnalyseFactory> */
    use HasFactory;

    protected $fillable = [
        'resultat',
        'bilan_id',
        'element_id',
        'locked_by',
    ];

    public function bilan(){
        return $this->belongsTo(Bilan::class);
    }

    public function element(){
        return $this->belongsTo(Element::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
