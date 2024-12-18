<?php

namespace App\Services;

use App\DTO\ConnectCommand;
use App\Enums\DeviceModel;
use App\Enums\Endpoints;
use App\Exceptions\ConnectException;
use App\Interfaces\ConnectUser;
use App\Models\Command;
use App\Models\Device;
use App\Models\Site;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

abstract class BaseCameConnect
{


    protected ?ConnectUser $user;
    protected Collection $connectSitesResponse;
    protected Collection $deviceIdents;
    protected ?Collection $siteList = null;
    protected bool $withStates = false;

    /**
     * @throws ConnectException
     */
    public function __construct(?ConnectUser $user = null)
    {
        $user
            ? $this->asUser($user)
            : $this->tryAuthenticatedUser();
    }

    protected function resetUser(): static
    {
        $this->user = null;;
        $this->connectSitesResponse = new Collection();
        $this->deviceIdents = new Collection();
        $this->siteList = new Collection();
        $this->withStates = false;
        return $this;
    }

    /**
     * @throws ConnectException
     */
    protected function asUser(ConnectUser $user): static
    {
        if (!is_subclass_of($user, ConnectUser::class)) {
            throw new ConnectException('User must implement ' . ConnectUser::class . ' interface.');
        }
        $this->resetUser();
        try {
            $user->getConnectBearerToken();
            $this->user = $user;
        } catch (ConnectException $e) {
            $this->user->forgetBearerToken();
        }
        return $this;
    }

    /**
     * @throws ConnectException
     */
    protected function tryAuthenticatedUser(): bool
    {
        if (!auth()->check()) return false;
        if (is_subclass_of(auth()->user(), ConnectUser::class)) {
            $this->asUser(auth()->user());
            return true;
        }
        return false;
    }

    /**
     * @throws ConnectException
     */
    public static function make(?ConnectUser $user = null): static
    {
        return $user
            ? app(static::class)->asUser($user)
            : app(static::class);
    }

    protected function apiGET(Endpoints|string $url, array $params = []): mixed
    {
        if (!is_string($url)) $url = $url->value;

        $request = Http::withToken($this->user->getConnectBearerToken())
            ->withUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36')
            ->acceptJson()
            ->get($url);

        if ($request->getStatusCode() !== 200) {
            throw new ConnectException($request->getStatusCode());
        }
        if (!$request->object()->Success) {
            throw new ConnectException($request->getStatusCode());
        }
        return $request->object()->Data;
    }

    protected function apiPOST(Endpoints|string $url): object|string|null
    {
        $request = Http::withToken($this->user->getConnectBearerToken())
            ->acceptJson()
            ->withUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36')
            ->post($url);
        return $request->object();

    }

    private function loadSites(): static
    {
        if ($this->connectSitesResponse->isNotEmpty()) return $this;

        $this->connectSitesResponse = cache()
            ->remember(
                self::getConnectSitesCacheKey(),
                60,
                fn() => collect($this->apiGET(Endpoints::SITES))
            );
        $this->collectDevicesIdents();
        return $this;
    }

    private function getConnectSitesCacheKey(): string
    {
        return 'sites:' . $this->user->getConnectUsername();
    }

    private function collectDevicesIdents(): void
    {
        $this->deviceIdents = collect();
        $this
            ->connectSitesResponse
            ->each(function ($site) {
                collect($site->Devices)
                    ->each(function ($device) {
                        $this->deviceIdents->push($device->Id);
                    });
            });
    }

    private function getRawSites(): Collection
    {
        $this->loadSites();
        return $this->connectSitesResponse;
    }

    private function getDeviceIdents(): Collection
    {
        $this->loadSites();
        return $this->deviceIdents;
    }

    protected function syncSites(): static
    {
        $sites = [];
        foreach ($this->getRawSites() as $rawSite) {
            $sites[] = Site::updateOrCreate(
                ['id' => $rawSite->Id],
                [
                    'name' => $rawSite->Name,
                    'description' => $rawSite->Description,
                    'address' => $rawSite->Address,
                    'latitude' => $rawSite->Latitude,
                    'longitude' => $rawSite->Longitude,
                    'timezone' => $rawSite->Timezone,
                    'technician_id' => $rawSite->TechnicianId,
                ]
            );
        }
        $this->user->sites()->sync($sites);
        return $this;
    }

    protected function syncDevices(): static
    {
        foreach ($this->getRawSites() as $rawSite) {
            $deviceIds = [];
            foreach ($rawSite->Devices as $rawDevice) {
                $device = Device::updateOrCreate(
                    ['id' => $rawDevice->Id],
                    [
                        'name' => $rawDevice->Name,
                        'description' => $rawDevice->Description,
                        'connected_thru' => $rawDevice->ParentId,
                        'icon_name' => $rawDevice->IconName,
                        'remotes_max' => $rawDevice->RemotesMax,
                        'model_id' => $rawDevice->ModelId,
                        'model_name' => $rawDevice->ModelName,
                        'model_description' => $rawDevice->ModelDescription,
                        'keycode' => $rawDevice->Keycode,
                        'category_id' => $rawDevice->CategoryId,
                        'local_inputs' => $rawDevice->LocalInputs,
                        'local_outputs' => $rawDevice->LocalOutputs,
                        'site_id' => $rawSite->Id,
                    ]
                );
                $deviceIds[] = $device->id;
            }
            // remove not connected devices;
            Site::find($rawSite->Id)->devices()->whereNotIn('id', $deviceIds)->delete();
        }

        return $this;
    }

    protected function syncCommands(): static
    {
        Device::query()
            ->with('commands')
            ->whereIn('model_id', DeviceModel::commandables())
            ->whereHas(
                'site',
                fn($query) => $query
                    ->whereHas(
                        'user',
                        fn($query) => $query->where('id', $this->user->id)
                    )
            )
            ->get()
            ->each(fn(Device $device) => self::syncDeviceCommands($device));
        return $this;
    }

    private function syncDeviceCommands(Device $device): static
    {
        if (!$device->model_id->isCommandable()) return $this;

        $discoveredCommands = new Collection();

        if ($device->model_id->isAutomation()) {
            $this->fetchAutomationCommands($device->id)
                ->each(fn($command) => $discoveredCommands->push(ConnectCommand::make($command, $device->id, true)));
        } else {
            $this->fetchDeviceCommands($device->id)
                ->each(fn($command) => $discoveredCommands->push(ConnectCommand::make($command, $device->id, false)));
        }

        $discoveredCommands
            ->transform(fn(ConnectCommand $command) => Command::updateOrCreate($command->getSelectData(), $command->getUpdateData()))
            ->transform(fn(Command $command) => $command->id);

        Command::query()
            ->where('device_id', $device->id)
            ->whereNotIn('id', $discoveredCommands)
            ->delete();

        return $this;
    }

    private function fetchDeviceCommands(int $id): Collection
    {
        return collect($this->apiGET(Endpoints::DEVICE_COMMANDS->device($id))->Commands);
    }

    private function fetchAutomationCommands(int $id): Collection
    {
        return collect($this->apiGET(Endpoints::AUTOMATION_COMMANDS->device($id))->Commands);
    }

    public function sendDeviceCommand(Device|int $device, int $commandId): object|string|null
    {
        $device = $device instanceof Device ? $device->id : $device;
        return $this->apiPOST(Endpoints::SEND_DEVICE_COMMAND->command($device, $commandId));
    }

    public function sendAutomationCommand(Device|int $device, int $commandId): object|string|null
    {
        $device = $device instanceof Device ? $device->id : $device;
        return $this->apiPOST(Endpoints::SEND_AUTOMATION_COMMAND->command($device, $commandId));
    }


}
