<?php

namespace App\Controller;

use App\Repository\SettingsRepository;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\Client;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class StreamController extends AbstractController
{
    /**
     * @throws GuzzleException
     * @throws InvalidArgumentException
     */
    #[Route('/stream', name: 'app_stream')]
    public function index(SettingsRepository $settingsRepository): Response
    {
        $cache = new FilesystemAdapter();
        $clientId = $this->getParameter('app.twitch_client_id');
        $clientSecret = $this->getParameter('app.twitch_client_secret');
        $channelId = $this->getParameter('app.twitch_channel_id');

        $cacheKey = 'upcoming_streams';
        $cache->deleteItem($cacheKey);

        $cachedStreams = $cache->getItem($cacheKey);
        if (!$cachedStreams->isHit()) {
            $client = new Client();

            $response = $client->post('https://id.twitch.tv/oauth2/token', [
                'form_params' => [
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                    'grant_type' => 'client_credentials',
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            $accessToken = $data['access_token'];

            $response = $client->get("https://api.twitch.tv/helix/schedule?broadcaster_id={$channelId}&first=6", [
                'headers' => [
                    'Client-ID' => $clientId,
                    'Authorization' => "Bearer {$accessToken}",
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            $upcomingStreams = $data['data']['segments'];

            $cachedStreams->set($upcomingStreams);
            $cache->save($cachedStreams);
            dump('notcatched');
        } else {
            $upcomingStreams = $cachedStreams->get();
            dump('catched');
        }


        return $this->render('public/stream/index.html.twig', [
            'upcoming_streams' => $upcomingStreams,
            'settings' => $settingsRepository->findAll()[0],
        ]);
    }
}
