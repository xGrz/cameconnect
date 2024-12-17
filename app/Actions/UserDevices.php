<?php

namespace App\Actions;

use App\Models\Device;
use Illuminate\Support\Collection;

class UserDevices
{

    public static function get(): Collection
    {
        return Device::select('id')
            ->whereIn('site_id', self::findUserSites())
            ->get();
    }

    public static function getIdents(): Collection
    {
        return self::get()
            ->flatten()
            ->pluck('id');
    }

    private static function findUserSites(): Collection
    {
        return self::getUser()
            ->loadMissing('sites')
            ->sites
            ->flatten()
            ->pluck('id');
    }

    private static function getUser(): \App\Models\User
    {
        return auth()->user();
    }

}
