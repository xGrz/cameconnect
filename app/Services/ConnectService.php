<?php

namespace App\Services;

use App\DTO\Status;
use App\Enums\Endpoints;
use App\Models\Device;
use App\Models\Site;
use Illuminate\Support\Collection;

class ConnectService extends BaseCameConnect
{

    public function sync(): static
    {
        return $this
            ->syncSites()
            ->syncDevices()
            ->syncCommands();
    }

    public function getStates(): Collection
    {
        $devices = $this->user->getUserDevicesIds();
        return collect($this->apiGET(Endpoints::DEVICE_STATUS->devices($devices)))
            ->transform(fn($item) => new Status($item));

    }

    public function sendCommand(Device $device, int $command): bool
    {
        if ($device->model_id->isNotCommandable()) return false;
        $device->model_id->isAutomation()
            ? $this->sendAutomationCommand($device, $command)
            : $this->sendDeviceCommand($device, $command);
        return true;
    }

    public function getTree(bool $asArray = false): Collection|array
    {
        $this->user->loadMissing('sites.devices.commands');

        $sites = $this
            ->user
            ->sites
            ->transform(fn(Site $site) => $site->toTree(true));

        return $asArray ? $sites->toArray() : $sites;
    }
}
