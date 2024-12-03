<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ConnectService
{
    private ?string $client_id = null;
    private ?string $client_secret = null;

    private ?string $username;
    private ?string $password;

    public function __construct()
    {
        self::fillClientCredentials();
        // self::refreshClientIdAndSecret();
    }

    private function refreshClientIdAndSecret(): void
    {
        $jsFiles = self::getJSFilesFromCameConnect();
        $mainJsFile = self::findMainJsFile($jsFiles);
        $secrets = self::findClientIdAndSecretFromMainJsFile($mainJsFile);
        $this->client_id = $secrets['client_id'];
        $this->client_secret = $secrets['client_secret'];
    }

    private function getJSFilesFromCameConnect(): array
    {
        $content = Http::get(config('cameconnect.host') . '/login')->body();
        preg_match_all('/src="([^"]+\.js)"/', $content, $files);
        return $files[1];
    }

    private function findMainJsFile(array $jsFiles): string
    {
        return collect($jsFiles)->first(fn($filename) => str($filename)->startsWith('main.'));
    }

    private function findClientIdAndSecretFromMainJsFile($jsFileWithSecrets): array
    {
        $jsFileContent = Http::get(config('cameconnect.host') . '/' . $jsFileWithSecrets)->body();
        if (preg_match('/clientId:"([a-f0-9]+)"/', $jsFileContent, $matchesClientId)) {
            $clientId = $matchesClientId[1];
        } else {
            $clientId = null;
        }

        if (preg_match('/clientSecret:"([a-f0-9]+)"/', $jsFileContent, $matchesClientSecret)) {
            $clientSecret = $matchesClientSecret[1];
        } else {
            $clientSecret = null;
        }
        return ['client_id' => $clientId, 'client_secret' => $clientSecret];
    }

    private function fillClientCredentials(): void
    {
        $this->client_id = config('cameconnect.client_id');
        $this->client_secret = config('cameconnect.client_secret');
        $this->username = config('cameconnect.username');
        $this->password = config('cameconnect.password');
    }

}
