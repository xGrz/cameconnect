<?php

namespace App\DTO\State;

readonly class ConnectCommand
{
    public int $commandId;
    public string $label;
    public object $raw;

    public function __construct(?object $command, public int $deviceId, public bool $isAutomation = false)
    {
        $this->commandId = $command->Id;
        $this->label = $command->Description;
        $this->raw = $command; //todo: remove raw when non in debug mode
    }
}
