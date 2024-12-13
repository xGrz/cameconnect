<?php

namespace App\Services;

use App\DTO\DeviceStatus;
use App\DTO\Site;
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
        return collect($this->apiGET(Endpoints::DEVICE_COMMANDS->device($id))->Commands);
    }

    public function automationCommands(int $id): Collection
    {
        return collect($this->apiGET(Endpoints::AUTOMATION_COMMANDS->device($id))->Commands);
    }
}
