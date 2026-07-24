<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotReactif extends Model
{
    use HasFactory;

    protected $fillable = [
        'reactif_id',
        'numero_lot',
        'quantite_initiale',
        'quantite_restante',
        'prix_achat',
        'date_achat',
        'date_peremption',
        'fournisseur_lot',
        'est_consommable',
    ];

    protected $casts = [
        'date_peremption' => 'date',
        'date_achat' => 'date',
        'est_consommable' => 'boolean',
        'quantite_initiale' => 'decimal:2',
        'quantite_restante' => 'decimal:2',
        'prix_achat' => 'decimal:2',
    ];

    // ─── Relations ───────────────────────────────────────────────────────────

    public function reactif()
    {
        return $this->belongsTo(Reactif::class);
    }

    public function mouvements()
    {
        return $this->hasMany(MouvementStock::class);
    }

    // ─── Accesseurs ─────────────────────────────────────────────────────────

    public function getEstPerimeAttribute(): bool
    {
        return $this->date_peremption < now()->toDateString();
    }
    

    public function getEstVideAttribute(): bool
    {
        return $this->quantite_restante <= 0;
    }

    // ─── Méthodes métier ────────────────────────────────────────────────────

    /**
     * Déduire une quantité de ce lot (avec vérification de disponibilité)
     * Retourne la quantité réellement déduite.
     */
    public function deduire(float $quantite): float
    {
        if (!$this->est_consommable || $this->est_perime || $this->est_vide) {
            return 0;
        }

        $deduit = min($quantite, $this->quantite_restante);
        $this->quantite_restante -= $deduit;

        // Si le lot est vide, on le rend non consommable pour les futures recherches
        if ($this->quantite_restante <= 0) {
            $this->est_consommable = false;
        }

        $this->save();

        return $deduit;
    }
}
