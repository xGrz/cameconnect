<?php

namespace App\Services;

use App\Enums\Endpoints;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class ConnectService
{
    private function __construct(private readonly string $bearerToken)
    {
    }

    public static function make(string $bearerToken): self
    {
        return new self($bearerToken);
    }

    private function callGet(Endpoints $url, array $params = []): string
    {
        $url = $url->value;
        if ($params !== []) {
            $url = str($url)->replace(array_keys($params), array_values($params))->toString();
        }

        return Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->bearerToken,
        ])->get($url);
    }

    public function sites()
    {
        return $this->callGet(Endpoints::SITES)->object()?->Data[0];
    }

    public function devices(): Collection
    {
        return collect($this->sites()->Devices);
    }

    public function deviceStatus(array|int $ids)
    {
        if (is_array($ids)) $ids = join(',', $ids);
        return json_decode($this->callGet(Endpoints::DEVICE_STATUS, ['DEVICE_IDS' => $ids]));
    }


}
