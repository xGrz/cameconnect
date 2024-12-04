<?php

namespace App\DTO;

use App\Models\Device;

class DeviceStatus
{

    private array $state = [
        'id' => null,
        'name' => '',
        'model' => '',
        'online' => false,
        'came' => '',
    ];

    private function __construct(object $state)
    {
        $device = Device::find($state->Id);
        $this->state['id'] = $state->Id;
        $this->state['name'] = $device->name;
        $this->state['model'] = $device->model_name;
        $this->state['online'] = $state->Online;
        $this->state['came'] = $state;
    }

    public static function make(object $state): DeviceStatus
    {
        return (new self($state));
    }

    public function getState(): array
    {
        return $this->state;
    }

}
