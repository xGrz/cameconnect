<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Command extends Model
{
    protected $fillable = [
        'user_id',
        'device_id',
        'command_id',
        'is_automation',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'is_automation' => 'boolean',
        ];
    }
}
