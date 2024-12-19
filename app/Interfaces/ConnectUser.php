<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface ConnectUser
{
    public function getConnectBearerToken(): ?string;

    public function getConnectUsername(): ?string;

    public function sites(): BelongsToMany;
}
