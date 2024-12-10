<?php

namespace App\DTO;

use Illuminate\Support\Collection;

class BaseConnectItem
{
    public int $id;
    public string $name;
    public string $description;
    public Collection $devices;
}
