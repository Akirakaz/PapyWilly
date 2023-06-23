<?php

namespace App\Controller;

use App\Repository\SettingsRepository;
use DateInterval;
use Doctrine\ORM\NonUniqueResultException;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
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
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws InvalidArgumentException
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws NonUniqueResultException
     */
    #[Route('/videos', name: 'app_videos')]
    public function index(YoutubeAPIService $youtubeAPIService, SettingsRepository $settingsRepository): Response
    {
        $cache = new FilesystemAdapter();
        $youtubeVideos = $cache->getItem('youtube_videos');

        if (!$youtubeVideos->isHit()) {
            $youtubeVideos->set($youtubeAPIService->getLatestVideos());
            $youtubeVideos->expiresAfter(new DateInterval('PT1H'));
            $cache->save($youtubeVideos);
        }

        return $this->render('public/video/index.html.twig', [
            'youtubeVideos' => $youtubeVideos->get(),
            'settings' => $settingsRepository->getSettings(),
        ]);
    }
}