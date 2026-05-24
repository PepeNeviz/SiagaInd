<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TasSiaga extends Model
{
    protected $table = 'tas_siaga';

    protected $fillable = [
        'session_id',
        'nama_tas',
        'kategori',
        'liter',
        'dim_p',  // panjang (cm)
        'dim_l',  // lebar (cm)
        'dim_t',  // tinggi (cm)
    ];

    protected $casts = [
        'liter' => 'float',
        'dim_p' => 'float',
        'dim_l' => 'float',
        'dim_t' => 'float',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(TasItem::class, 'tas_id');
    }

    /**
     * Hitung liter dari dimensi jika belum diset
     */
    public function getLiterAttribute($value): float
    {
        if ($value) return (float) $value;
        if ($this->dim_p && $this->dim_l && $this->dim_t) {
            return round($this->dim_p * $this->dim_l * $this->dim_t / 1000, 1);
        }
        return 0;
    }

    public function hasSupply(string $keyword): bool
    {
        return $this->items()
            ->where('nama_item', 'like', "%{$keyword}%")
            ->exists();
    }
}
