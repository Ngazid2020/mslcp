<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reactif extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'reference',
        'fournisseur',
        'unite_mesure',
        'seuil_alerte',
        'est_actif',
    ];

    protected $casts = [
        'est_actif' => 'boolean',
        'seuil_alerte' => 'decimal:2',
    ];

    // ─── Relations ───────────────────────────────────────────────────────────

    public function lots()
    {
        return $this->hasMany(LotReactif::class);
    }

    public function elements()
    {
        return $this->belongsToMany(Element::class, 'element_reactif')
                    ->withPivot('quantite_consommee');
    }

    // ─── Méthodes métier ────────────────────────────────────────────────────

    /**
     * Retourne le stock total disponible (somme des quantités restantes des lots consommables et non périmés)
     */
    public function getStockDisponibleAttribute(): float
    {
        return (float) $this->lots()
            ->where('est_consommable', true)
            ->where('date_peremption', '>=', now()->toDateString())
            ->sum('quantite_restante');
    }

    /**
     * Retourne les lots triés par date de péremption (FEFO) pour ce réactif
     */
    public function getLotsFefo()
    {
        return $this->lots()
            ->where('est_consommable', true)
            ->where('quantite_restante', '>', 0)
            ->where('date_peremption', '>=', now()->toDateString())
            ->orderBy('date_peremption')
            ->get();
    }
    
}