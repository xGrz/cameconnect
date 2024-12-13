<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Exceptions\ConnectException;
use App\Services\ConnectLoginService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

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

    /**
     * @throws ConnectException
     */
    public function getBearerToken(): ?string
    {
        if (empty($this->connect_username) || empty($this->connect_password)) {
            throw new ConnectException('Login credentials are empty');
        }
        return cache()
            ->remember(
                self::getCacheKeyForBearerToken(),
                7190,
                fn() => ConnectLoginService::login($this->connect_username, $this->connect_password)->getBearer()
            );
    }

    public function forgetBearerToken(): bool
    {
        return cache()->forget(self::getCacheKeyForBearerToken());
    }

    private function getCacheKeyForBearerToken(): string
    {
        return 'bearer-token:' . $this->id;
    }

    public function commands(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Command::class);
    }

}
