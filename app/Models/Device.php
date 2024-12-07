<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Device extends Model
{
    public $incrementing = false;

    protected $guarded = [];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

}
