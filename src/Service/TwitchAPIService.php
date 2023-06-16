<?php

namespace App\Service;

use DateTime;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Utils;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TwitchAPIService
{
    private const OAUTH_URL = 'https://id.twitch.tv/oauth2/token';
    private const SCHEDULE_URL = 'https://api.twitch.tv/helix/schedule';
    private array $parameters;
    private Client $client;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameters = [
            'clientPublic' => $parameterBag->get('app.twitch_client_id'),
            'clientSecret' => $parameterBag->get('app.twitch_client_secret'),
            'channelId' => $parameterBag->get('app.twitch_channel_id'),
        ];
    }

    /**
     * @throws GuzzleException
     */
    private function getBearer(): mixed
    {
        $this->client = new Client();

        $response = $this->client->post(self::OAUTH_URL, [
            'form_params' => [
                'client_id' => $this->parameters['clientPublic'],
                'client_secret' => $this->parameters['clientSecret'],
                'grant_type' => 'client_credentials',
            ],
        ]);

        return Utils::jsonDecode($response->getBody(), true);
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function getSchedule(): mixed
    {
        $weekNow = new DateTime('now');
        $weekNow->setISODate($weekNow->format('Y'), $weekNow->format('W'));
        $weekStart = $weekNow->format('Y-m-d') . 'T00:00:00Z';

        $query = [
            'broadcaster_id' => $this->parameters['channelId'],
            'start_time' => $weekStart,
        ];

        $bearer = $this->getBearer();

        $response = $this->client->get(self::SCHEDULE_URL . '?' . http_build_query($query), [
            'headers' => [
                'Client-ID' => $this->parameters['clientPublic'],
                'Authorization' => "Bearer {$bearer['access_token']}",
            ]
        ]);

        return Utils::jsonDecode($response->getBody(), true)['data'];
    }
}