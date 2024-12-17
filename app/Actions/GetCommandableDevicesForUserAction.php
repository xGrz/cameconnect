<?php

namespace App\Actions;

use App\Enums\DeviceModel;
use App\Models\Device;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class GetCommandableDevicesForUserAction
{
    public static function get(?User $user = null): Collection
    {
        if (empty($user)) $user = auth()->user();

        return Device::query()
            ->with('commands')
            ->whereIn('model_id', DeviceModel::commandables())
            ->whereHas(
                'site',
                fn($query) => $query
                    ->whereHas(
                        'user',
                        fn($query) => $query->where('id', $user->id)
                    )
            )
            ->get();
    }
}
