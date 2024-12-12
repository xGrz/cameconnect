<?php

namespace App\DTO\State;

use App\DTO\DeviceStatus;
use App\Enums\DeviceModel;
use Illuminate\Support\Collection;

class ConnectDevice
{
    public readonly int $id;
    public readonly string $name;
    public readonly string $description;
    public readonly int $remotesMax;
    public readonly int $modelId;
    public readonly string $modelName;
    public readonly ?DeviceModel $model;
    public readonly string $iconName;
    public readonly ?string $keyCode;
    public readonly int $categoryId;
    public readonly int $inputs;
    public readonly int $outputs;
    public bool $online = false;
    public ?object $states = null;
    public bool $commandable = false;
    public bool $isAutomation = false;
    public ?int $parentId = null;

    public Collection $children;

    public Collection $commands;

    public function __construct(object $device, ?DeviceStatus $status = null)
    {
        $this->commands = collect();
        $this->id = $device->Id;
        $this->parentId = $device->ParentId;
        $this->name = $device->Name;
        $this->description = $device->Description;
        $this->remotesMax = (isset($device->remotesMax)) ? $device->remotesMax : 0;
        $this->modelId = $device->ModelId;
        $this->modelName = $device->ModelName;
        $this->iconName = $device->IconName;
        $this->keyCode = (isset($device->KeyCode)) ? $device->KeyCode : null;
        $this->categoryId = $device->CategoryId;
        $this->inputs = $device->LocalInputs ?? 0;
        $this->outputs = $device->LocalOutputs ?? 0;
        $this->model = DeviceModel::tryFrom($this->modelId) ?? null;

        if ($this->model) {
            $this->commandable = $this->model->isCommandable();
            $this->isAutomation = $this->model->isAutomation();
        }

        if ($status) {
            $this->online = $status->online;
            $this->states = $status->states;
        }
    }
}
