<?php

namespace App\Services;

use App\DTO\Status;
use App\Enums\Endpoints;
use App\Models\Device;
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

    public function getTree(): array
    {
        $this->user->loadMissing('sites.devices.commands');
        $sites = $this->user->sites->map(function ($site) {
            $site = $site->toArray();
            $devices = $site['devices'];
            unset($site['devices'], $site['pivot'], $site['created_at'], $site['updated_at']);
            $site['devices'] = self::buildTree($devices)->toArray();
            return $site;
        });
        return $sites->toArray();
    }

    private function buildTree(array $devices, ?int $parentId = null): Collection
    {
        return collect($devices)->filter(fn($item) => $item['connected_thru'] === $parentId)
            ->map(function ($item) use ($devices) {
                unset($item['created_at'], $item['updated_at']);
                $item['devices'] = self::buildTree($devices, $item['id'])->values()->toArray();
                return $item;
            });
    }
}
