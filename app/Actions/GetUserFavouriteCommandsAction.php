<?php

namespace App\Actions;

use App\Models\Device;
use App\Models\User;
use Illuminate\Support\Collection;

class GetUserFavouriteCommandsAction
{

    private User $user;

    public function get(): Collection
    {
        $this->user = auth()->user();
        $commands = $this->favoritesCommandsByDevices();
        $devices = $this->getDevicesForCommands($commands);

        return self::buildDevicesCommands($devices, $commands);
    }

    private function favoritesCommandsByDevices(): Collection
    {
        return $this->user->favoritesCommands()
            ->with(['device' => fn($q) => $q->select('id')])
            ->withPivot('position')
            ->orderByPivot('position')
            ->orderBy('command')
            ->get()
            ->groupBy('device_id');
    }

    private function getDevicesForCommands(Collection $commands): Collection
    {
        return Device::whereIn('id', $commands->keys())
            ->with('parent_device')
            ->get();
    }

    private function buildDevicePath(Device $device, ?Collection $path = null): Collection
    {
        if (is_null($path)) $path = new Collection();
        $path->push($device);
        if ($device->parent_device) $path = self::buildDevicePath($device->parent_device, $path);
        return $path;
    }

    private function buildDevicesCommands(Collection $devices, Collection $commands): Collection
    {
        return $devices->transform(function ($device) use ($commands) {
            return [
                'id' => $device->id,
                'name' => $device->name,
                'description' => $device->description,
                'commands' => $commands[$device->id]
                    ->values()
                    ->transform(fn($command) => [
                        'commandId' => $command->id,
                        'label' => $command->label,
                        'systemName' => $command->system_name
                    ])
                    ->toArray(),
                'path' => $this->buildDevicePath($device)
                    ->transform(fn(Device $device) => [
                        'deviceId' => $device->id,
                        'name' => $device->name,
                        'description' => $device->description,
                    ]),
            ];
        });
    }


}
