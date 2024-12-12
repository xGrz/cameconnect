<?php

namespace App\Services;

use App\DTO\DeviceStatusDTO;
use App\DTO\SiteDTO;
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

    public function withStates(bool $withStates = true): static
    {
        $this->withStates = $withStates;
        return $this;
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
                ->push(new SiteDTO($site, $states))
            );
    }

    public function getDeviceStates(): Collection
    {
        $this->loadSites();
        return collect($this->apiGET(Endpoints::DEVICE_STATUS->devices($this->deviceIdents->toArray())))
            ->transform(fn($status) => new DeviceStatusDTO($status));
    }
}
