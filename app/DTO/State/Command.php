<?php

namespace App\DTO\State;

readonly class Command
{
    public function __construct(public int $commandId)
    {
    }
}
