<?php

namespace App\DTO;

use App\DTO\State\ConnectCommand;
use App\DTO\State\ConnectDevice;
use App\Services\Connect;
use Illuminate\Support\Collection;

class Site
{
    public readonly int $id;
    public readonly string $name;
    public readonly string $description;
    public readonly Collection $devicesList;
    public readonly Collection $devicesTree;

    public Collection $commands;

    public function __construct(object $site, protected ?Collection $states = null)
    {
        $this->id = $site->Id;
        $this->name = $site->Name;
        $this->description = $site->Description;

        $this->devicesList = new Collection();

        collect($site->Devices)
            ->each(function ($device) use ($states) {
                $this
                    ->devicesList
                    ->push(new ConnectDevice($device, $this->findDeviceState($device->Id, $states)));
            });

        $this->devicesTree = self::buildDevicesTree($this->devicesList);

        // $this->commands = new Collection();
        $this->commands = cache()->remember('siteCommands:' . $this->id, 1, fn() => self::collectCommands());
        $this->pushCommandsToDevices();
    }

    private function findDeviceState(int $deviceId, ?Collection $states = null)
    {
        if (empty($states)) return null;
        return $states->first(function ($state) use ($deviceId) {
            return $state->id === $deviceId;
        });
    }

    public function buildDevicesTree(Collection $items, int $parentId = null)
    {
        return $items->filter(function ($item) use ($parentId) {
            return $item->parentId === $parentId;
        })->map(function ($item) use ($items) {
            $item->children = self::buildDevicesTree($items, $item->id);
            return $item;
        })->values();
    }

    private function collectCommands(): Collection
    {
        $commands = collect();
        $this
            ->getCommandableDevices()
            ->each(fn($device) => collect(Connect::withoutSites()->deviceCommands($device->id))
                ->each(fn($command) => $commands->push(new ConnectCommand($command, $device->id, $device->isAutomation)))
            );

        $this
            ->getAutomationDevices()
            ->each(fn($automation) => collect(Connect::withoutSites()->automationCommands($automation->id))
                ->each(fn($command) => $commands->push(new ConnectCommand($command, $automation->id, $automation->isAutomation)))
            );
        return $commands;
    }

    private function getAutomationDevices()
    {
        return $this
            ->devicesList
            ->filter(fn(ConnectDevice $device) => $device->isAutomation);
    }

    private function getCommandableDevices()
    {
        return $this
            ->devicesList
            ->filter(fn(ConnectDevice $device) => $device->isAutomation === false && $device->commandable);
    }

    private function pushCommandsToDevices(): void
    {
        $this->commands->each(function ($command) {
            $this->devicesList->first(fn(ConnectDevice $device) => $device->id === $command->deviceId)
                ->commands->push($command);
        });
    }

}
