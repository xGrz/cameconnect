<?php

namespace App\Enums;

enum Endpoints: string
{
    const BASE_URL = 'https://app.cameconnect.net/api';
    case SITES = self::BASE_URL . '/sites';
    case DEVICE_STATUS = self::BASE_URL . '/devicestatus?devices=[DEVICE_IDS]';

    case DEVICE_COMMANDS = self::BASE_URL . '/multiio/DEVICE_ID/commands';

    case SEND_COMMAND = self::BASE_URL . '/multiio/DEVICE_ID/commands/COMMAND_ID';

    public function devices(int|array $id): string
    {
        if (is_array($id)) $id = join(',', $id);

        return str($this->value)
            ->replace('DEVICE_IDS', $id)
            ->toString();
    }

    public function device(int $id): string
    {
        return str($this->value)
            ->replace('DEVICE_ID', $id)
            ->toString();
    }

    public function command(int $deviceId, int $command_id): string
    {
        return str($this->value)
            ->replace('DEVICE_ID', $deviceId)
            ->replace('COMMAND_ID', $command_id)
            ->toString();
    }
}
