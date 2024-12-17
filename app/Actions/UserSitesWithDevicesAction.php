<?php

namespace App\Actions;

use App\Models\Device;

class UserSitesWithDevicesAction
{
    public static function getTree(bool $asArray = false)
    {
        $user = auth()->user()->loadMissing('sites.devices');

        $sites = $user
            ->sites
            ->transform(fn ($site) => $site->toTree($asArray));

        return $asArray
            ? $sites->toArray()
            : $sites;
    }
}
