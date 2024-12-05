<?php

namespace App\Services;

use App\DTO\DeviceCommand;
use App\DTO\DeviceStatus;
use App\Enums\Endpoints;
use App\Exceptions\ConnectException;
use App\Models\Device;
use App\Models\Site;
use App\Models\User;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class ConnectService
{
    private User $user;
    private Collection $sites;
    private string $bearerToken;

    private function __construct(User $user)
    {
        $this->user = $user;
        try {
            $this->bearerToken = $user->getBearerToken();
        } catch (ConnectionException|ConnectException $e) {
            $user->forgetBearerToken();
        }
        $this->sites = collect();
    }

    public static function make(User $user): self
    {
        return new self($user);
    }

    /**
     * @throws ConnectionException
     */
    private function apiGET(Endpoints|string $url, array $params = []): mixed
    {
        if (!is_string($url)) $url = $url->value;

        $request = Http::withToken($this->bearerToken)
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

    private function apiPOST(Endpoints|string $url)
    {
        $request = Http::withToken($this->bearerToken)
            ->acceptJson()
            ->withUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36')
            ->post($url);
        return $request->object();

    }

    public function sites(): Collection
    {
        if ($this->sites->isEmpty()) {
            $this->sites = collect($this->apiGET(Endpoints::SITES));
        }
        return $this->sites;
    }

    public function sync(): static
    {
        if ($this->sites->isEmpty()) $this->sites();
        $this->sites->each(function ($site) {

            // site sync
            $localSite = Site::updateOrCreate(
                ['id' => $site->Id],
                ['id' => $site->Id, 'user_id' => $this->user->id, 'name' => $site->Name, 'description' => $site->Description, 'timezone' => $site->Timezone]
            );

            // devices sync
            collect($site->Devices)
                ->each(function ($device) use (&$localSite) {
                    $localSite->devices()->updateOrCreate(
                        ['id' => $device->Id],
                        [
                            'id' => $device->Id,
                            'name' => $device->Name,
                            'description' => $device->Description,
                            'parent_id' => $device->ParentId,
                            'model_id' => $device->ModelId,
                            'model_description' => $device->ModelDescription,
                            'model_name' => $device->ModelName,
                            'key_code' => $device->Keycode,
                            'icon' => $device->IconName,
                            'inputs' => $device->LocalInputs,
                            'outputs' => $device->LocalOutputs,
                            'max_remotes' => $device->RemotesMax,
                        ]
                    );
                });

        });
        return $this;
    }


    public function deviceStatus(array|int $ids): Collection
    {
        $statuses = collect();
        $liveStates = collect($this->apiGET(Endpoints::DEVICE_STATUS->devices($ids)));
        return $liveStates;
        $liveStates->each(function ($state) use ($statuses) {
            $statuses->push(DeviceStatus::make($state));
        });

        return $statuses;
    }


    public function commands(int $id)
    {
        $commands = collect($this->apiGET(Endpoints::DEVICE_COMMANDS->device($id))->Commands);
        return $commands->map(function ($command) use ($id) {
            return DeviceCommand::id($id, $command);
        });
    }

    public function sendCommand(Device|int $device, int $commandId)
    {
        $device = $device instanceof Device ? $device->id : $device;
        return $this->apiPOST(Endpoints::SEND_COMMAND->command($device, $commandId));

    }
}
