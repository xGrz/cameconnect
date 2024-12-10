<?php

namespace App\DTO;

use App\Services\CameConnect;
use Illuminate\Support\Collection;

class DeviceDTO extends BaseConnectDevice
{
    public array $allowedInputs;
    public ?Collection $commands = null;

    public function __construct(object $device, ?Collection $statuses = null)
    {
        parent::__construct($device, $statuses);
        if (isset($device->AllowedInputs)) {
            $this->allowedInputs = $device?->AllowedInputs;
        }

        if ($this->model->canHaveCommands()) {
            $this->commands = CameConnect::make(auth()->user())
                ->deviceCommands($this->id)
                ->transform(fn($command) => new Command($command));
        } elseif ($this->model->isAutomation()) {
            $this->commands = CameConnect::make(auth()->user())
                ->automationCommands($this->id)
                ->transform(fn($command) => new Command($command));
        }
    }
}
