<?php

namespace App\Controller;

use App\Enums\CacheExpirationEnums;
use App\Repository\SettingsRepository;
use App\Service\CacheSystem;
use Doctrine\ORM\NonUniqueResultException;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\YoutubeAPIService;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class VideoController extends AbstractController
{
    /**
     * @throws InvalidArgumentException
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws NonUniqueResultException
     */
    #[Route('/videos', name: 'app_videos')]
    public function index(
        CacheSystem        $cacheSystem,
        YoutubeAPIService  $youtubeAPIService,
        SettingsRepository $settingsRepository
    ): Response
    {
        if (!$cacheSystem->isHit('youtube_videos')) {
            $cacheSystem->setCache(
                'youtube_videos',
                $youtubeAPIService->getLatestVideos(),
                CacheExpirationEnums::HOURS_6
            );
        }

        if (!$cacheSystem->isHit('settings')) {
            $cacheSystem->setCache(
                'settings',
                $settingsRepository->getSettings(),
                CacheExpirationEnums::HOURS_6
            );
        }

        return $this->render('public/video/index.html.twig', [
            'youtubeVideos' => $cacheSystem->getCache('youtube_videos'),
            'settings'      => $cacheSystem->getCache('settings'),
        ]);
    }
}