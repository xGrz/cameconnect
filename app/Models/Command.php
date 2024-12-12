<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Command extends Model
{
    protected $fillable = [
        'device_id',
        'command_id',
        'label',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }
}
