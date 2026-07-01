<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Bilan extends Model
{
    /** @use HasFactory<\Database\Factories\BilanFactory> */
    use HasFactory;

    protected $fillable = [
        'ref',
        'type',
        'patient_id',
    ];

    /**
     * The patient that this bilan belongs to.
     */
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
            ->withPivot('resultat',)
            ->withTimestamps();
    }

    public function maladies(): BelongsToMany
    {
        return $this->belongsToMany(Maladie::class)->withTimestamps();
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($bilan) {
            $year  = date('Y');
            $month = date('m');
            $count = Bilan::query()->whereYear('created_at', '=', $year)->count() + 1;
            $bilan->ref = 'LAB-' . $year . '-' . $month . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
        });
    }
}
