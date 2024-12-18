<?php

namespace App\Models;

use App\Enums\DeviceModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Device extends Model
{
    public $incrementing = false;

    protected $casts = [
        'model_id' => DeviceModel::class
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class, 'connected_thru', 'id');
    }

    public function commands(): HasMany
    {
        return $this->hasMany(Command::class);
    }
}
