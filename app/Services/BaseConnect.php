<?php

namespace App\Services;

use App\Enums\Endpoints;
use App\Exceptions\ConnectException;
use App\Models\User;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

abstract class BaseConnect
{
    protected User $user;
    protected Collection $connectSitesResponse;
    protected Collection $deviceIdents;

    public function __construct(?User $user = null)
    {
        $this->user = $user ?? auth()->user();

        $this->connectSitesResponse = collect();
        try {
            $this->user->getBearerToken();
        } catch (ConnectionException|ConnectException $e) {
            $user->forgetBearerToken();
        }
    }

    public static function withSites(): static
    {
        $instance = app(static::class);
        $instance->loadSites();
        return $instance;
    }

    public static function withoutSites(): static
    {
        return app(static::class);
    }

    protected function apiGET(Endpoints|string $url, array $params = []): mixed
    {
        if (!is_string($url)) $url = $url->value;

        $request = Http::withToken($this->user->getBearerToken())
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
        $request = Http::withToken($this->user->getBearerToken())
            ->acceptJson()
            ->withUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36')
            ->post($url);
        return $request->object();

    }

    public function loadSites(): static
    {
        if ($this->connectSitesResponse->isNotEmpty()) return $this;
        $this->retrieveSites();
        return $this;
    }

    public function retrieveSites(): static
    {
        $this->connectSitesResponse = cache()
            ->remember(
                self::getSitesCacheKey(),
                10,
                fn() => collect($this->apiGET(Endpoints::SITES))
            );
        $this->collectDevicesIdents();
        return $this;
    }

    private function getSitesCacheKey(): string
    {
        return 'sites:' . $this->user->id;
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
}
