<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Bacteriologie extends Model
{
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
        return $this->belongsToMany(AnalyseUrinaire::class, 'analyse_bacts')
            ->using(AnalyseBact::class)
            ->withPivot('resultat',)
            ->withTimestamps();
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($bilan) {
            $year = date('Y');
            $mounth = date('m');
            $count = Bacteriologie::whereYear('created_at', $year)->count() + 1;
            $bilan->ref = 'URI-' . $year . '-' .$mounth.'-'. str_pad($count, 3, '0', STR_PAD_LEFT);
        });
    }
}
