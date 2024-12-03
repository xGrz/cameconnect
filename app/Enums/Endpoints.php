<?php

namespace App\Enums;

enum Endpoints: string
{
    const BASE_URL = 'https://app.cameconnect.net';
    case SITES = self::BASE_URL . '/api/sites';
    case DEVICE_STATUS = self::BASE_URL . '/api/devicestatus?devices=[DEVICE_IDS]';
}
