<?php

namespace App\Services;

use App\DTO\DeviceStatus;
use App\DTO\FavoriteCommand;
use App\DTO\Site;
use App\DTO\State\ConnectCommand;
use App\Enums\Endpoints;
use Illuminate\Support\Collection;

class Connect extends BaseConnect
{
    protected ?Collection $siteList = null;
    protected bool $withStates = false;

    public function getSiteList(): Collection
    {
        if (empty($this->siteList)) {
            self::buildStructure();
        }
        return $this->siteList;
    }

    public static function getSitesTree(): Collection
    {
        return app(self::class)
            ->getSiteList()
            ->transform(fn($site) => $site->toTree());
    }

    public function withStates(bool $withStates = true): static
    {
        $this->withStates = $withStates;
        return $this;
    }

    public function withoutStates(): static
    {
        return app(self::class);
    }

    private function buildStructure(): void
    {
        $this->loadSites();
        $this->siteList = new Collection();
        $states = $this->withStates
            ? self::getDeviceStates()
            : null;

        $this
            ->connectSitesResponse
            ->each(fn($site) => $this
                ->siteList
                ->push(new Site($site, $states))
            );
    }

    public function getDeviceStates(): Collection
    {
        $this->loadSites();
        return collect($this->apiGET(Endpoints::DEVICE_STATUS->devices($this->deviceIdents->toArray())))
            ->transform(fn($status) => new DeviceStatus($status));
    }

    public function deviceCommands(int $id): Collection
    {
        return cache()
            ->remember(
                "device:{$id}",
                60,
                fn() => collect($this->apiGET(Endpoints::DEVICE_COMMANDS->device($id))->Commands)
            );
    }

    public function automationCommands(int $id): Collection
    {
        return collect($this->apiGET(Endpoints::AUTOMATION_COMMANDS->device($id))->Commands);
    }

    public static function favoriteCommands(): Collection
    {
        $instance = app(self::class);
        $siteCommands = collect();
        $instance->withStates()->getSiteList()->each(function ($site) use ($siteCommands) {
            $site->commands->each(function ($command) use ($siteCommands) {
                $siteCommands->push($command);
            });
        });

        $allDevices = new Collection();
        $instance->getSiteList()->each(function ($site) use ($allDevices) {
            $site->devicesList->each(function ($device) use ($allDevices) {
                $allDevices->push($device);
            });
        });

        return $instance->user->commands->transform(function ($command) use ($siteCommands, $instance, $allDevices) {
            $originalCommand = $siteCommands->first(function (ConnectCommand $siteCommand) use ($command) {
                return $siteCommand->deviceId == $command->device_id
                    && $siteCommand->commandId == $command->command_id;
            });
            $currentDevice = $allDevices->first(fn($siteDevice) => $siteDevice->id === $command->device_id);
            $parentDevice = $allDevices->first(fn($siteDevice) => $siteDevice->id === $currentDevice->parentId);
            return new FavoriteCommand($command, $originalCommand, $parentDevice);
        });
    }

    public static function directGetDevicesStates(Collection|array|int $deviceIds): Collection
    {
        if (is_int($deviceIds)) $deviceIds = [$deviceIds];
        if ($deviceIds instanceof Collection) $deviceIds = $deviceIds->toArray();

        $instance = app(self::class);
        return collect($instance->apiGET(Endpoints::DEVICE_STATUS->devices($deviceIds)))
            ->transform(fn($status) => new DeviceStatus($status));
    }
}
