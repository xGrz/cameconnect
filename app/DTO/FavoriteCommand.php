<?php

namespace App\DTO;

use App\DTO\State\ConnectCommand;
use App\Models\Command;

class FavoriteCommand
{

    public int $device;
    public int $command;
    public bool $isAutomation;
    public string $label;
    public string $deviceName;
    public string $deviceDescription;
    public string $iconName;

    public function __construct(Command $command, ConnectCommand $connectCommand, $device)
    {
        $this->device = $command->device_id;
        $this->command = $command->command_id;
        $this->isAutomation = $command->is_automation;
        $this->label = $connectCommand->label;
        $this->deviceName = $device->name;
        $this->deviceDescription = $device->description;
        $this->iconName = $device->iconName;
    }
}
