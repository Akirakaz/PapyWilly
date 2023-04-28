<?php

namespace App\Events;

use App\Entity\SocialNetwork;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Event\PostRemoveEventArgs;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Doctrine\ORM\Events;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class SocialNetworkSubscriber implements EventSubscriberInterface
{
    private FilesystemAdapter $cache;

    public function __construct()
    {
        $this->cache = new FilesystemAdapter();
    }
    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
            Events::postUpdate,
            Events::postRemove,
        ];
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

        $this->cache->delete('socialNetworks');
    }
}