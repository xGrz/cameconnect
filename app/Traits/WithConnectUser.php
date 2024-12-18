<?php

namespace App\Traits;

use App\Exceptions\ConnectException;
use App\Services\ConnectLoginService;

trait WithConnectUser
{

    public function getConnectUsername(): ?string
    {
        return $this->connect_username;
    }

    private function getConnectPassword(): string
    {
        return $this->connect_password;
    }

    public function getConnectBearerToken(): ?string
    {
        if (empty($this->getConnectUsername()) || empty($this->getConnectPassword())) {
            throw new ConnectException('Login credentials are empty');
        }
        return cache()
            ->remember(
                self::getConnectCacheKeyForBearerToken(),
                7190,
                fn() => ConnectLoginService::login($this->getConnectUsername(), $this->getConnectPassword())->getBearer()
            );
    }

    public function forgetBearerToken(): bool
    {
        return cache()
            ->forget(self::getConnectCacheKeyForBearerToken());
    }

    private function getConnectCacheKeyForBearerToken(): string
    {
        return 'bearer-token:' . $this->getConnectUsername();
    }

}
