<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Maladie extends Model
{
    protected $fillable = ['nom', 'code', 'actif'];

    protected $casts = ['actif' => 'boolean'];

    public function bilans(): BelongsToMany
    {
        return $this->belongsToMany(Bilan::class)->withTimestamps();
    }
}
