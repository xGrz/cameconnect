<?php

namespace App\Services;

use App\Enums\Endpoints;
use App\Exceptions\ConnectException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

readonly class ConnectService
{

    private function __construct(private string $bearerToken)
    {
    }

    public static function make(string $bearerToken): self
    {
        return new self($bearerToken);
    }

    /**
     * @throws ConnectionException
     */
    private function apiGET(Endpoints|string $url)
    {
        if (!is_string($url)) {
            $url = $url->value;
        }

        $request = Http::withToken($this->bearerToken)
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

    public function sites()
    {
        $sites = $this->apiGET(Endpoints::SITES);
        return $sites;
    }


    public function deviceStatus(array|int $ids)
    {
        return json_decode($this->apiGET(Endpoints::DEVICE_STATUS->devices($ids)));
    }


}
