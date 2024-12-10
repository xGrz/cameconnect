<?php

namespace App\DTO;

class Command
{
    public int $commandId;
    public string $label;
    public ?int $outputId;

    public function __construct(object $command)
    {
        $this->commandId = $command->Id;
        $this->label = $command->Description;
        if (isset($command->OutputId)) {
            $this->outputId = $command?->OutputId;
        } else {
            $this->outputId = null;
        }

    }
}
