<?php

namespace App\DTO\State;

readonly class InputState
{

    public function __construct(public int $inputId, public string $state)
    {
    }
}
