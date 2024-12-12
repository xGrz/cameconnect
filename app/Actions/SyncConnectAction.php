<?php

namespace App\Actions;

use App\Models\Site;
use App\Models\User;
use App\Services\CameConnect;

class SyncConnectAction
{

    private function __construct(private readonly User $user)
    {
        $this->sync();
    }

    public static function make(?User $user = null): SyncConnectAction
    {
        if (empty($user)) $user = auth()->user();
        if (empty($user)) throw new \Exception('User not logged in.');
        return new static($user);
    }


    private function sync()
    {
        $sites = CameConnect::make($this->user)
            ->getSites()
            ->each(function ($site) {
                $siteModel = Site::updateOrCreate(
                    ['id' => $site->id],
                    ['name' => $site->name, 'timezone' => $site->timezone, 'description' => $site->description, 'technical_id' => $site->technicianId]
                );
            });


    }

}
