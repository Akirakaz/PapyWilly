<?php

namespace App\Events;

use App\Entity\Banner;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Events;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;

class DeleteImageCache implements EventSubscriberInterface
{
    private CacheManager $cacheManager;

    public function __construct(CacheManager $cacheManager)
    {
        $this->cacheManager = $cacheManager;
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
        ];
    }

    public function postPersist(PostPersistEventArgs $args): void
    {
        if (!$args->getObject() instanceof Banner) {
            return;
        }

        $this->cacheManager->remove();
    }
}