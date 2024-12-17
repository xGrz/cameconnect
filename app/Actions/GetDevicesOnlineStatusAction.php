<?php

namespace App\Actions;

use App\Services\Connect;
use App\Traits\Cacheable;
use Illuminate\Support\Collection;

class GetDevicesOnlineStatusAction
{
    use Cacheable;
    protected static ?string $cacheName = 'userDevicesOnlineStatus';

    public static function get(): Collection
    {
        $userDevices = UserDevices::getIdents();
        if ($userDevices->isEmpty()) return collect();

        return cache()
            ->remember(
                self::getCacheKey(),
                self::getCacheExpire(),
                fn() => Connect::directGetDevicesStates($userDevices)
                    ->transform(fn($item) => ['id' => $item->id, 'online' => $item->online])
            );
    }


}
