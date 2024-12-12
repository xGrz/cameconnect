<?php

namespace App\Services;

use App\DTO\SiteDTO;
use App\Enums\Endpoints;
use App\Exceptions\ConnectException;
use App\Models\Device;
use App\Models\User;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class CameConnect
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
        $this->sites = $this->fetchSites();
    }

    public static function make(?User $user = null): self
    {
        if (empty($user)) {
            $user = auth()->user() ?? throw new \Exception('User not logged in');
        }
        return new self($user);
    }

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

    private function fetchSites(): Collection
    {
        if ($this->sites->isEmpty()) {
            $this->sites = collect($this->apiGET(Endpoints::SITES));
        }
        return $this->sites;
    }

    public function getSites(bool $withStatus = true): Collection
    {
        $sites = collect();
        foreach ($this->sites as $site) {
            $sites->push(new SiteDTO($site, $withStatus));
        }
        return $sites;
    }

    public function getStatus(array|int $ids): Collection
    {
        return collect($this->apiGET(Endpoints::DEVICE_STATUS->devices($ids)));
    }

    public function deviceCommands(int $id): Collection
    {
        return collect($this->apiGET(Endpoints::DEVICE_COMMANDS->device($id))->Commands);
    }

    public function automationCommands(int $id): Collection
    {
        return collect($this->apiGET(Endpoints::AUTOMATION_COMMANDS->device($id))->Commands);
    }

    public function sendDeviceCommand(Device|int $device, int $commandId)
    {
        $device = $device instanceof Device ? $device->id : $device;
        return $this->apiPOST(Endpoints::SEND_DEVICE_COMMAND->command($device, $commandId));
    }

    public function sendAutomationCommand(Device|int $device, int $commandId) {
        $device = $device instanceof Device ? $device->id : $device;
        return $this->apiPOST(Endpoints::SEND_AUTOMATION_COMMAND->command($device, $commandId));
    }
}
