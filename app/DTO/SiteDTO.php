<?php

namespace App\DTO;

use App\Services\CameConnect;
use Illuminate\Support\Collection;

class SiteDTO extends BaseConnectItem
{
    public string $timezone;
    public int $technicianId;
    public Collection $deviceIds;

    public function __construct(object $site, bool $withStatus = false)
    {
        $this->devices = new Collection();
        $this->deviceIds = new Collection();

        $this->id = $site->Id;
        $this->name = $site->Name;
        $this->description = $site->Description;
        $this->timezone = $site->Timezone;
        $this->technicianId = $site->TechnicianId;

        foreach ($site->Devices as $device) {
            $this->deviceIds->push($device->Id);
        }

        $states = collect();
        if ($withStatus) {
            $statuses = CameConnect::make(auth()->user())->getStatus($this->deviceIds->toArray());
            foreach ($statuses as $status) {
                $states->push( new DeviceStatusDTO($status));
            }
        }

        foreach ($site->DevicesTree->Children as $device) {
            $this->devices->push(new GatewayDTO($device, $states));
        }

    }
}
