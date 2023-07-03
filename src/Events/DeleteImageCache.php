<?php

namespace App\Events;

use App\Entity\Banner;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Events;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;

#[AsDoctrineListener(event: Events::postPersist, priority: 500, connection: 'default')]

class DeleteImageCache
{
    private CacheManager $cacheManager;

    public function __construct(CacheManager $cacheManager)
    {
        $this->cacheManager = $cacheManager;
    }

    public function postPersist(PostPersistEventArgs $args): void
    {
        if (!$args->getObject() instanceof Banner) {
            return;
        }

        $this->cacheManager->remove();
    }
}