<?php

namespace App\Enums;

enum DeviceModel: int
{
    case QBE = 18;
    case RSLV = 10;
    case IO = 26;
    case ZN7 = 60;

    public function canHaveCommands(): bool
    {
        return match ($this) {
            self::IO => true,
            default => false
        };
    }

    public function isAutomation(): bool
    {
        return match ($this) {
            self::ZN7 => true,
            default => false
        };
    }

    public function isCommandable(): bool
    {
        return $this->canHaveCommands() || $this->isAutomation();
    }
}
