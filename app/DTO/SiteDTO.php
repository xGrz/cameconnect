<?php

namespace App\DTO;

use App\Services\Connect;
use Illuminate\Support\Collection;

class SiteDTO extends BaseConnectItem
{
    public string $timezone;
    public int $technicianId;
    public ?Collection $deviceIds = null;

    public Collection $devices;

    public function __construct(object $site, ?Collection $states = null)
    {
        $this->children = new Collection();
        $this->deviceIds = new Collection();

        $this->id = $site->Id;
        $this->name = $site->Name;
        $this->description = $site->Description;
        $this->timezone = $site->Timezone;
        $this->technicianId = $site->TechnicianId;

        foreach ($site->Devices as $device) {
            $this->deviceIds->push($device->Id);
        }

        foreach ($site->DevicesTree->Children as $device) {
            $this->devices->push(new GatewayDTO($device, $states));
        }

    }
}
