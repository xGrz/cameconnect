<?php

namespace App\Actions;

use App\Models\Device;
use App\Models\Site;
use App\Models\User;
use App\Services\Connect;

class SyncConnectAction
{
    private Connect $service;

    private function __construct()
    {
        $this->service = Connect::withSites();
        $this->sync();
    }

    public static function make(?User $user = null): SyncConnectAction
    {
        if (empty($user)) $user = auth()->user();
        if (empty($user)) throw new \Exception('User not logged in.');
        return new static($user);
    }

    private function syncSites(): static
    {
        $sites = [];
        foreach ($this->service->getRawSites() as $rawSite) {
            $sites[] = Site::updateOrCreate(
                ['id' => $rawSite->Id],
                [
                    'name' => $rawSite->Name,
                    'description' => $rawSite->Description,
                    'address' => $rawSite->Address,
                    'latitude' => $rawSite->Latitude,
                    'longitude' => $rawSite->Longitude,
                    'timezone' => $rawSite->Timezone,
                    'technician_id' => $rawSite->TechnicianId,
                ]
            );
        }
        auth()->user()->sites()->sync($sites);
        return $this;
    }

    private function syncDevices(): static
    {
        foreach ($this->service->getRawSites() as $rawSite) {
            $deviceIds = [];
            foreach ($rawSite->Devices as $rawDevice) {
                $device = Device::updateOrCreate(
                    ['id' => $rawDevice->Id],
                    [
                        'name' => $rawDevice->Name,
                        'description' => $rawDevice->Description,
                        'connected_thru' => $rawDevice->ParentId,
                        'icon_name' => $rawDevice->IconName,
                        'remotes_max' => $rawDevice->RemotesMax,
                        'model_id' => $rawDevice->ModelId,
                        'model_name' => $rawDevice->ModelName,
                        'model_description' => $rawDevice->ModelDescription,
                        'keycode' => $rawDevice->Keycode,
                        'category_id' => $rawDevice->CategoryId,
                        'local_inputs' => $rawDevice->LocalInputs,
                        'local_outputs' => $rawDevice->LocalOutputs,
                        'site_id' => $rawSite->Id,
                    ]
                );
                $deviceIds[] = $device->id;
            }
            // remove not connected devices;
            Site::find($rawSite->Id)->devices()->whereNotIn('id', $deviceIds)->delete();
        }

        return $this;
    }

    private function syncCommands(): static
    {
        GetCommandableDevicesForUserAction::get()
            ->each(fn(Device $device) => $device->syncCommands());
        return $this;
    }

    private function sync(): void
    {
        $this
            ->syncSites()
            ->syncDevices()
            ->syncCommands();
    }

}
