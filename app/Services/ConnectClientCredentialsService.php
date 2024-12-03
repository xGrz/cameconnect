<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ConnectClientCredentialsService
{
    public static function get(): array
    {
        $jsFiles = self::getJSFilesFromCameConnect();
        $mainJsFile = self::findMainJsFile($jsFiles);
        $secrets = self::findClientIdAndSecretFromMainJsFile($mainJsFile);
        return [
            'client_id' => $secrets['client_id'],
            'client_secret' => $secrets['client_secret'],
        ];
    }

    private static function getJSFilesFromCameConnect(): array
    {
        $content = Http::get(config('cameconnect.host') . '/login')->body();
        preg_match_all('/src="([^"]+\.js)"/', $content, $files);
        return $files[1];
    }

    private static function findMainJsFile(array $jsFiles): string
    {
        return collect($jsFiles)->first(fn($filename) => str($filename)->startsWith('main.'));
    }

    private static function findClientIdAndSecretFromMainJsFile($jsFileWithSecrets): array
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
}
