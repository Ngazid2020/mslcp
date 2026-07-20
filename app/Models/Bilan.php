<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Bilan extends Model
{
    use HasFactory;

    protected $fillable = [
        'ref',
        'type',
        'patient_id',
        'prescripteur_id',
        'statut',
        'prix_total',
    ];

    protected $casts = [
        'statut' => 'string',
        'prix_total' => 'integer',
    ];

    // ─── Relations ───────────────────────────────────────────────────────────

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function prescripteur()
    {
        return $this->belongsTo(Prescripteur::class);
    }

    public function elements(): BelongsToMany
    {
        return $this->belongsToMany(Element::class, 'analyses')
            ->using(Analyse::class)
            ->withPivot('resultat')
            ->withTimestamps();
    }

    public function maladies(): BelongsToMany
    {
        return $this->belongsToMany(Maladie::class)->withTimestamps();
    }

    // ─── Accesseurs / Mutateurs ─────────────────────────────────────────────

    public function getStatutLabelAttribute(): string
    {
        return match ($this->statut) {
            'en_attente_prelevement' => 'En attente de prélèvement',
            'preleve'                => 'Prélevé',
            'en_cours_analyse'       => 'En cours d\'analyse',
            'termine'                => 'Terminé',
            default                  => $this->statut,
        };
    }

    public function getStatutColorAttribute(): string
    {
        return match ($this->statut) {
            'en_attente_prelevement' => 'warning',
            'preleve'                => 'info',
            'en_cours_analyse'       => 'primary',
            'termine'                => 'success',
            default                  => 'gray',
        };
    }

    // ─── Boot ─────────────────────────────────────────────────────────────────

    public static function boot()
    {
        parent::boot();

        static::creating(function ($bilan) {
            $year  = date('Y');
            $month = date('m');
            $count = Bilan::query()->whereYear('created_at', '=', $year)->count() + 1;
            $bilan->ref = 'LAB-' . $year . '-' . $month . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

            // Si le prix total n'est pas défini manuellement, on le calcule
            if ($bilan->prix_total === null) {
                $bilan->prix_total = 0;
            }
        });

        // Met à jour le prix_total automatiquement si on ajoute des éléments
        static::saving(function ($bilan) {
            if ($bilan->exists && $bilan->prix_total === null) {
                $bilan->prix_total = $bilan->elements()->sum('prix');
            }
        });
    }

    // ─── Calcul du total à la volée ────────────────────────────────────────

    public function calculateTotal(): int
    {
        return $this->elements()->sum('prix') ?? 0;
    }

    public function refreshTotal(): void
    {
        $this->prix_total = $this->calculateTotal();
        $this->saveQuietly();
    }
}