<?php

namespace App\Models;

use App\Interfaces\ConnectUser;
use App\Traits\WithConnectUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

class User extends Authenticatable implements ConnectUser
{
    use HasFactory;
    use Notifiable;
    use WithConnectUser;

    protected $hidden = [
        'password',
        'remember_token',
        'connect_password'
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'connect_password' => 'encrypted',
        ];
    }

    public function sites(): BelongsToMany
    {
        return $this->belongsToMany(Site::class);
    }

    public function getUserDevices(): Collection
    {
        $sites = $this->sites->pluck('id')->toArray();
        return Device::whereIn('site_id', $sites)->get();
    }

    public function getUserDevicesIds(): array
    {
        return $this->getUserDevices()->pluck('id')->toArray();
    }

    public function favoritesCommands(): BelongsToMany
    {
        return $this->belongsToMany(Command::class);
    }

}
