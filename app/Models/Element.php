<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Element extends Model
{
    /** @use HasFactory<\Database\Factories\ElementFactory> */
    use HasFactory;

    protected $fillable = [
        'nom',
        'ref_inf_h',
        'ref_sup_h',
        'ref_inf_f',
        'ref_sup_f',
        'ref_inf_enf',
        'ref_sup_enf',
        'ref_inf_nour',
        'ref_sup_nour',
        'ref_inf_nne',
        'ref_sup_nne',
        'norme_enfant',
        'norme_nourisson',
        'unite',
        'category_id',
        'type_valeur',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function bilans(): BelongsToMany
    {
        return $this->belongsToMany(Bilan::class)->using(Analyse::class);
    }
}
