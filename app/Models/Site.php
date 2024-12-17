<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Site extends Model
{
    public $incrementing = false;

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }

    public function toTree(bool $asArray = false): Collection|array
    {
        return self::buildDevicesTree(
            items: $this->devices,
            asArray: $asArray
        );
    }

    private function buildDevicesTree(Collection $items, int $parentId = null, bool $asArray = false): Collection|array
    {
        return $items
            ->filter(fn($item) => $item->connected_thru === $parentId)
            ->map(function ($item) use ($items, $asArray) {
                $item->devices = self::buildDevicesTree($items, $item->id);
                if ($asArray) $item->devices = $item->devices->toArray();
                return $item;
            })->values()
            ->when($asArray, function ($items) {
                return $items->toArray();
            });
    }
}
