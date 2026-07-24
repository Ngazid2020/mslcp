<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MouvementStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'lot_reactifs_id',
        'bilan_id',
        'quantite',
        'type',
        'motif',
        'user_id',
    ];

    protected $casts = [
        'quantite' => 'decimal:2',
    ];

    // ─── Relations ───────────────────────────────────────────────────────────

    public function lot()
    {
        return $this->belongsTo(LotReactif::class, 'lot_reactifs_id');
    }

    public function bilan()
    {
        return $this->belongsTo(Bilan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
