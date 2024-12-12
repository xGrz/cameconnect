<?php

namespace App\DTO\State;

readonly class OutputState
{

    public function __construct(public int $outputId, public string $state)
    {
    }
}
