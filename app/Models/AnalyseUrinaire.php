<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AnalyseUrinaire extends Model
{
    protected $fillable = [
        'nom',
        'category_analyse_id'
    ];

    public function category_analyse()
    {
        return $this->belongsTo(CategoryAnalyse::class);
    }

    public function bacteriologies(): BelongsToMany
    {
        return $this->belongsToMany(Bacteriologie::class, 'analyse_bacts')
            ->using(AnalyseBact::class)
            ->withPivot('resultat')
            ->withTimestamps();
    }
}
