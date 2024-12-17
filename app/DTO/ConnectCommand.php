<?php

namespace App\DTO;

readonly class ConnectCommand
{
    public string $label;
    public ?string $system_name;
    public int $command;

    private function __construct(object $apiCommand, public int $deviceId, public bool $automation)
    {
        $this->command = $apiCommand->Id;
        $this->system_name = $apiCommand->Name ?? null;
        $this->label = $apiCommand->Description;
    }

    public static function make(object $apiCommand, int $deviceId, bool $automation): static
    {
        return new static($apiCommand, $deviceId, $automation);
    }

    public function getSelectData(): array
    {
        return [
            'device_id' => $this->deviceId,
            'command' => $this->command,
        ];
    }

    public function getUpdateData(): array
    {
        return [
            'system_name' => $this->system_name,
            'automation' => $this->automation,
            'label' => $this->label,
        ];
    }
}
