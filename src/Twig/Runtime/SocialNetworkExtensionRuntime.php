<?php

namespace App\Twig\Runtime;

use App\Repository\SocialNetworkRepository;
use DateInterval;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Twig\Extension\RuntimeExtensionInterface;

class SocialNetworkExtensionRuntime implements RuntimeExtensionInterface
{
    private const CACHE_TTL = 'P1Y';
    private const CACHE_KEY = 'socialNetworks';

    private SocialNetworkRepository $socialNetworkRepository;
    private FilesystemAdapter $cache;

    public function __construct(SocialNetworkRepository $socialNetworkRepository)
    {
        $this->socialNetworkRepository = $socialNetworkRepository;
        $this->cache = new FilesystemAdapter();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getCachedSocialNetworks(): ?array
    {
        $cachedNetworks = $this->cache->getItem(self::CACHE_KEY);

        if (!$cachedNetworks->isHit()) {
            $networkList = $this->socialNetworkRepository->findAll();

            $cachedNetworks->set($networkList);

            $cacheTtl = new DateInterval(self::CACHE_TTL);
            $cachedNetworks->expiresAfter($cacheTtl);

            $this->cache->save($cachedNetworks);
        }

        return $cachedNetworks->get();
    }
}