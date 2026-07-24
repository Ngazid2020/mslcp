<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ElementReactif extends Pivot
{
    protected $table = 'element_reactif';

    protected $fillable = [
        'element_id',
        'reactif_id',
        'quantite_consommee',
    ];

    public function element(): BelongsTo
    {
        return $this->belongsTo(Element::class);
    }

    public function reactif(): BelongsTo
    {
        return $this->belongsTo(Reactif::class);
    }
}