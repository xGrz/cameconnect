<?php

namespace App\Enums;

enum IODeviceCommand: int
{
    case ACTIVATE = 0;
    case DEACTIVATE = 1;
    case CLICK = 2;
}
