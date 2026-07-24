<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Bacteriologie extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ref',
        'type',
        'patient_id',
        'prescripteur_id',
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($bacteriologie) {
            $year  = date('Y');
            $month = date('m');

            $count = DB::transaction(function () use ($year, $month) {
                return Bacteriologie::query()
                    ->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->lockForUpdate()
                    ->count() + 1;
            });

            $bacteriologie->ref = 'URI-' . $year . '-' . $month . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
        });
    }
}
