<?php

namespace App\Controller;

use App\Service\TwitchAPIService;
use App\Service\TwitchScheduleService;
use DateInterval;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class StreamController extends AbstractController
{
    /**
     * @throws Exception
     * @throws GuzzleException
     * @throws InvalidArgumentException
     */
    #[Route('/stream', name: 'app_stream')]
    public function index(TwitchScheduleService $twitchSchedule, TwitchAPIService $twitchAPI): Response
    {
        $cache = new FilesystemAdapter();
        $streamSchedule = $cache->getItem('stream_schedule');

        if (!$streamSchedule->isHit()) {
            $streamSchedule->set($twitchAPI->getSchedule());
            $streamSchedule->expiresAfter(new DateInterval('PT1H'));
            $cache->save($streamSchedule);
        }

        $data = $streamSchedule->get();

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
