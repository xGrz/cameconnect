<?php

namespace App\Models;

use App\DTO\ConnectCommand;
use App\Enums\DeviceModel;
use App\Services\Connect;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Device extends Model
{
    public $incrementing = false;

    protected $casts = [
        'model_id' => DeviceModel::class
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class, 'connected_thru', 'id');
    }

    public function commands(): HasMany
    {
        return $this->hasMany(Command::class);
    }

    public function syncCommands(): void
    {
        if (!$this->model_id->isCommandable()) return;

        $discoveredCommands = new Collection();

        if ($this->model_id->isAutomation()) {
            Connect::withoutSites()
                ->automationCommands($this->id)
                ->each(fn($command) => $discoveredCommands->push(
                    ConnectCommand::make(
                        $command,
                        $this->id,
                        $this->model_id->isAutomation())
                ));
        } else {
            Connect::withoutSites()
                ->deviceCommands($this->id)
                ->each(fn($command) => $discoveredCommands->push(
                    ConnectCommand::make(
                        $command,
                        $this->id,
                        $this->model_id->isAutomation())
                ));
        }

        $discoveredCommands
            ->transform(fn(ConnectCommand $command) => Command::updateOrCreate($command->getSelectData(), $command->getUpdateData()))
            ->transform(fn(Command $command) => $command->id);

        Command::query()
            ->where('device_id', $this->id)
            ->whereNotIn('id', $discoveredCommands)
            ->delete();
    }
}
