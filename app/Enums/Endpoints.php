<?php

namespace App\Enums;

enum Endpoints: string
{
    const BASE_URL = 'https://app.cameconnect.net';
    case SITES = self::BASE_URL . '/api/sites';
    case DEVICE_STATUS = self::BASE_URL . '/api/devicestatus?devices=[DEVICE_IDS]';

    public function devices(int|array $id): string
    {
        if (is_array($id)) $id = join(',', $id);
        return str($this->value)->replace('DEVICE_IDS', $id)->toString();
    }
}
