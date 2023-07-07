<?php

namespace App\Service;

use App\Enums\CacheExpirationEnums;
use DateInterval;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class CacheSystem
{
    private FilesystemAdapter $filesystemAdapter;

    public function __construct(FilesystemAdapter $filesystemAdapter)
    {
        $this->filesystemAdapter = $filesystemAdapter;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function isHit(string $key): bool
    {
        $cache = $this->filesystemAdapter->getItem($key);

        return $cache->isHit();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getCache(string $key): mixed
    {
        $cache = $this->filesystemAdapter->getItem($key);

        if (!$cache->isHit()) {
            return null;
        }

        return $cache->get();
    }

    /**
     * @throws InvalidArgumentException
     * @throws \Exception
     */
    public function setCache(string $key, mixed $value, CacheExpirationEnums $expiresAfter = CacheExpirationEnums::HOURS_1): void
    {
        $cache = $this->filesystemAdapter->getItem($key);

        $cache->set($value);
        $cache->expiresAfter(new DateInterval($expiresAfter->value));

        $this->filesystemAdapter->save($cache);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function deleteCache(string $key): void
    {
        $this->filesystemAdapter->deleteItem($key);
    }

    public function clearCache(): void
    {
        $this->filesystemAdapter->clear();
    }
}