<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Sous-type de Bilan pour les analyses hormonales.
 *
 * Utilise la même table `bilans` que Bilan, filtré par type = 'hormonal'.
 * Le champ `type` est automatiquement renseigné à la création.
 */
class BilanHormonal extends Bilan
{
    protected $table = 'bilans';

    protected static function booted(): void
    {
        static::addGlobalScope('hormonal', function (Builder $builder) {
            $builder->where('type', 'hormonal');
        });

        static::creating(function (BilanHormonal $bilan) {
            $bilan->type = 'hormonal';
        });
    }
}
