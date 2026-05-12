<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TasSiaga extends Model
{
    protected $table = 'tas_siaga';

    protected $fillable = [
        'session_id',
        // 'user_id', // uncomment saat ada login
        'nama_tas',
        'kategori',
        'liter',
    ];

    protected $casts = [
        'liter' => 'float',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(TasItem::class, 'tas_id');
    }

    public function itemsByZona(string $zona)
    {
        return $this->items()->where('zona', $zona)->get();
    }

    /**
     * Cek apakah tas punya item tertentu (untuk supply check di Sesudah)
     */
    public function hasSupply(string $keyword): bool
    {
        return $this->items()
            ->where('nama_item', 'like', "%{$keyword}%")
            ->exists();
    }
}
