<?php

namespace App\Controller;

use App\Enums\CacheExpirationEnums;
use App\Service\CacheSystem;
use App\Service\TwitchAPIService;
use App\Service\TwitchScheduleService;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StreamController extends AbstractController
{
    /**
     * @throws Exception
     * @throws GuzzleException
     * @throws InvalidArgumentException
     */
    #[Route('/stream', name: 'app_stream')]
    public function index(
        CacheSystem $cacheSystem,
        TwitchScheduleService $twitchSchedule,
        TwitchAPIService $twitchAPI): Response
    {
        if (!$cacheSystem->isHit('stream_schedule')) {
            $cacheSystem->setCache(
                'stream_schedule',
                $twitchAPI->getSchedule(),
                CacheExpirationEnums::HOURS_12
            );
        }

        $data = $cacheSystem->getCache('stream_schedule');

        $renderSchedule = $twitchSchedule->render($data);

        return $this->render('public/stream/index.html.twig', [
            'schedule'      => $renderSchedule['schedule'],
            'scheduleWeek'  => [
                'start' => $renderSchedule['scheduleWeek']['start'],
                'end'   => $renderSchedule['scheduleWeek']['end']
            ],
            'twitchChannel' => $data['broadcaster_name'],
        ]);
    }
}
