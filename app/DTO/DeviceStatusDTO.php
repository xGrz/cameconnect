<?php

namespace App\DTO;

use App\DTO\State\InputState;
use App\DTO\State\OutputState;
use App\DTO\State\Command;
use Illuminate\Support\Collection;

class DeviceStatusDTO
{
    public int $id;
    public bool $online;
    public Collection $states;
    public object $apiStateResponse;


    public function __construct(object $status)
    {
        $this->id = $status->Id;
        $this->online = $status->Online;
        $this->apiStateResponse = $status;
        $this->states = collect();
        collect($status->States)
            ->each(function ($state) {
                if (isset($state->OutputId)) {
                    $this->states->push(new OutputState($state->OutputId, $state->State));
                } elseif (isset($state->InputId)) {
                    $this->states->push(new InputState($state->InputId, $state->State));
                } elseif (isset($state->CommandId)) {
                    $this->states->push(new Command($state->CommandId));
                }
            });
    }

}
