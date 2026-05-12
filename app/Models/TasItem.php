<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TasItem extends Model
{
    protected $table = 'tas_items';

    protected $fillable = [
        'tas_id',
        'nama_item',
        'zona',
        'jumlah',
        'satuan',
    ];

    protected $casts = [
        'jumlah' => 'integer',
    ];

    public function tas(): BelongsTo
    {
        return $this->belongsTo(TasSiaga::class, 'tas_id');
    }
}
