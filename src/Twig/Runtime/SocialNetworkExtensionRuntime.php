<?php

namespace App\Twig\Runtime;

use App\Enums\CacheExpirationEnums;
use App\Repository\SocialNetworkRepository;
use App\Service\CacheSystem;
use Psr\Cache\InvalidArgumentException;
use Twig\Extension\RuntimeExtensionInterface;

class SocialNetworkExtensionRuntime implements RuntimeExtensionInterface
{
    private SocialNetworkRepository $socialNetworkRepository;
    private CacheSystem             $cacheSystem;

    public function __construct(SocialNetworkRepository $socialNetworkRepository, CacheSystem $cacheSystem)
    {
        $this->socialNetworkRepository = $socialNetworkRepository;
        $this->cacheSystem = $cacheSystem;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getCachedSocialNetworks(): ?array
    {
        if (!$this->cacheSystem->isHit('social_networks')) {
            $this->cacheSystem->setCache(
                'social_networks',
                $this->socialNetworkRepository->findAll(),
                CacheExpirationEnums::DAY_1
            );
        }

        return $this->cacheSystem->getCache('social_networks');
    }
}