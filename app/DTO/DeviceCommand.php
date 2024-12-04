<?php

namespace App\DTO;

use App\Models\Device;

class DeviceCommand
{
    public int $deviceId;
    public string $name;
    public string $command;
    public int $id;
    public int $outputId;

    private function __construct(Device $device, object $command)
    {
        $this->deviceId = $device->id;
        $this->name = $device->name;
        $this->command = $command->Description;
        $this->id = $device->id;
        $this->outputId = $command->OutputId;
    }

    public static function id(Device|int $device, object $command)
    {
        if (is_int($device)) {
            $device = Device::findOrFail($device);
        }
        return new self($device, $command);
    }

}
