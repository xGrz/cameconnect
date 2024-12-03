<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ConnectLoginService
{

    private ?string $codeVerifier = null;
    private ?string $codeChallenge = null;
    private ?string $code = null;
    private ?string $state = null;
    private ?string $bearer = null;
    private ?string $expires = null;
    private ?string $expiresDate = null;

    public static function login(string $username, string $password): ConnectLoginService
    {
        return new self($username, $password);
    }

    private function __construct(private readonly string $username, private readonly string $password)
    {
        $this->authCode();
        $this->fetchBearerToken();
    }

    private function getClientId(): string
    {
        return config('cameconnect.client_id');
    }

    private function getClientSecret(): string
    {
        return config('cameconnect.client_secret');
    }

    private function getCodeVerifier(int $length = 100): string
    {
        if ($this->codeVerifier) return $this->codeVerifier;

        $this->codeVerifier = Str::random($length);
        return $this->codeVerifier;
    }

    private function codeChallenge(): string
    {
        if ($this->codeChallenge) return $this->codeChallenge;;

        $hash = hash('sha256', $this->getCodeVerifier(), true);
        $this->codeChallenge = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($hash));
        return $this->codeChallenge;
    }

    public function authCode(): array
    {
        $url = URL::query('https://app.cameconnect.net/api/oauth/auth-code', [
            'client_id' => $this->getClientId(),
            'response_type' => 'code',
            'redirect_uri' => 'https://www.cameconnect.net/role',
            'state' => Str::random(100),
            'nonce' => Str::random(100),
            'code_challenge' => $this->codeChallenge(),
            'code_challenge_method' => 'S256',
        ]);
        $request = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($this->getClientId() . ':' . $this->getClientSecret()),
            'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
            'Accept' => 'application/json, text/plain, */*'
        ])
            ->withUserAgent('Google Chrome";v="131", "Chromium";v="131", "Not_A Brand";v="24"')
            ->asForm()
            ->post(urldecode($url), [
                'grant_type' => 'authorization_code',
                'client_id' => $this->getClientId(),
                'password' => $this->password,
                'username' => $this->username
            ]);
        $response = $request->object();
        $this->code = $response->code;
        $this->state = $response->state;
        return ['code' => $this->code, 'state' => $this->state];
    }

    private function fetchBearerToken(): array
    {
        $response = Http::withBasicAuth(config('cameconnect.client_id'), config('cameconnect.client_secret'))
            ->asForm()
            ->post('https://app.cameconnect.net/api/oauth/token', [
                'grant_type' => 'authorization_code',
                'code' => $this->code,
                'redirect_uri' => 'https://www.cameconnect.net/role',
                'code_verifier' => $this->codeVerifier,
            ]);
        $this->bearer = $response->object()->access_token;
        $this->expires = $response->object()->expires_in;
        $this->expiresDate = now()->addSeconds($response->object()->expires_in);
        return ['token' => $this->bearer, 'expires_in' => $this->expires];
    }

    public function getBearer(): ?string
    {
        return $this->bearer;
    }

    public function getExpiresDate(): ?string
    {
        return $this->expiresDate;
    }

    public function getExpires(): ?string
    {
        return $this->expires;
    }

}

