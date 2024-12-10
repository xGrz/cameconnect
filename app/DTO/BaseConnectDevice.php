<?php

namespace App\DTO;

use App\Enums\DeviceModel;
use Illuminate\Support\Collection;

class BaseConnectDevice extends BaseConnectItem
{
    public string $iconName;
    public int $modelId;
    public string $modelName;
    public string $keyCode;

    public ?DeviceStatusDTO $status;

    public ?DeviceModel $model;

    public function __construct(object $device, ?Collection $statuses = null)
    {
        $this->id = $device->Id;
        $this->name = $device->Name;
        $this->description = $device->Description;
        $this->iconName = $device->IconName;
        $this->modelId = $device->ModelId;
        $this->model = DeviceModel::tryFrom($device->ModelId);
        $this->modelName = $device->ModelName;
        $this->keyCode = $device->Keycode;
        $this->devices = new Collection();
        foreach ($device->Children as $childDevice) {
            $this->devices->push(new DeviceDTO($childDevice, $statuses));
        }
        if ($statuses) {
            $this->status = $statuses->first(fn($state) => $state->id === $device->Id);

        }

    }
}
