<?php

namespace App\Services;

use App\Models\Device;

class DeviceService
{

    private function __construct(private Device $device)
    {
    }


    public static function find(Device|int $device): static
    {
        if (is_int($device)) $device = Device::find($device);
        $device->loadMissing('children.children');
        return new static($device);
    }

    public function getCommands()
    {

    }

}
