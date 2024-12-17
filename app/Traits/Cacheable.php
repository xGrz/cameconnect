<?php

namespace App\Traits;

trait Cacheable
{

    protected static string $cachePrefix = 'user';
    protected static int $cacheExpire = 10;

    protected static function getCacheKey(): string
    {
        return join(':', [
            self::getCachePrefix(),
            self::getCacheUserId(),
            self::getCacheName()
        ]);
    }

    protected static function getCacheUserId(): int
    {
        return auth()->id();
    }

    protected static function getCachePrefix(): string
    {
        return static::$cachePrefix;
    }

    protected static function getCacheName(): string
    {
        if (empty(static::$cacheName)) throw new \Exception('Cache suffix is not set');
        return static::$cacheName;
    }

    protected static function getCacheExpire(): int
    {
        return static::$cacheExpire;
    }

}
