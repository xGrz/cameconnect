<?php

namespace App\DTO;

use App\Enums\DeviceModel;
use Illuminate\Support\Collection;

class DeviceStatusDTO
{
    public int $id;
    public bool $online;
    public Collection $states;
    public object $state;


    public function __construct(object $status)
    {
        $this->id = $status->Id;
        $this->online = $status->Online;
        $this->states = collect();
        $this->state = $status;
    }
}
