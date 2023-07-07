<?php

namespace App\Events;

use App\Entity\SocialNetwork;
use App\Service\CacheSystem;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Event\PostRemoveEventArgs;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Doctrine\ORM\Events;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

#[AsDoctrineListener(event: Events::postPersist, priority: 500, connection: 'default')]
#[AsDoctrineListener(event: Events::postUpdate, priority: 500, connection: 'default')]
#[AsDoctrineListener(event: Events::postRemove, priority: 500, connection: 'default')]
class SocialNetworkSubscriber
{
    private CacheSystem $cacheSystem;

    public function __construct(CacheSystem $cacheSystem)
    {
        $this->cacheSystem = $cacheSystem;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function postPersist(PostPersistEventArgs $args): void
    {
        $this->deleteSocialNetworkCache($args->getObject());
    }

    /**
     * @throws InvalidArgumentException
     */
    public function postUpdate(PostUpdateEventArgs $args): void
    {
        $this->deleteSocialNetworkCache($args->getObject());
    }

    /**
     * @throws InvalidArgumentException
     */
    public function postRemove(PostRemoveEventArgs $args): void
    {
        $this->deleteSocialNetworkCache($args->getObject());
    }

    /**
     * @throws InvalidArgumentException
     */
    private function deleteSocialNetworkCache(mixed $entity): void
    {
        if (!$entity instanceof SocialNetwork) {
            return;
        }

        $this->cacheSystem->deleteCache('social_networks');
    }
}