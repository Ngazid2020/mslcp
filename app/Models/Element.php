<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    /**
     * Retourne [min, max] de référence pour un patient donné.
     * Priorité : âge < 1 an → nourrisson-NNé, < 5 → nourrisson, < 16 → enfant, sinon adulte H/F.
     */
    public function getReferenceRange(Patient $patient): array
    {
        $age = (int) ($patient->age ?? 999);

        if ($age < 1) {
            return [$this->ref_inf_nne, $this->ref_sup_nne];
        }
        if ($age < 5) {
            return [$this->ref_inf_nour, $this->ref_sup_nour];
        }
        if ($age < 16) {
            return [$this->ref_inf_enf, $this->ref_sup_enf];
        }

        return $patient->sexe === 'F'
            ? [$this->ref_inf_f, $this->ref_sup_f]
            : [$this->ref_inf_h, $this->ref_sup_h];
    }

    /**
     * Indique si un résultat sort de la norme pour un patient donné.
     * — Qualitatif : tout résultat autre que "négatif" est considéré hors-norme.
     * — Numérique  : comparaison aux bornes de référence démographiques.
     * — Autres     : retourne false (pas d'alerte).
     */
    public function isResultOutOfRange(mixed $value, Patient $patient): bool
    {
        if ($value === null || $value === '') {
            return false;
        }

        if ($this->type_valeur === 'qualitatif') {
            $normalized = strtolower(trim((string) $value));
            return ! in_array($normalized, ['négatif', 'negatif', '-', 'non détecté', 'non detecte']);
        }

        if (! is_numeric($value)) {
            return false;
        }

        [$min, $max] = $this->getReferenceRange($patient);

        if ($min === null && $max === null) {
            return false;
        }

        $numVal = (float) $value;

        return ($min !== null && $numVal < (float) $min)
            || ($max !== null && $numVal > (float) $max);
    }
}
