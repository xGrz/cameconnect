<?php

namespace App\Interfaces;

interface ConnectUser
{
    public function getConnectBearerToken(): ?string;

    public function getConnectUsername(): ?string;

}
