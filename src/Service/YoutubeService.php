<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class YoutubeService
{
    private $httpClient;
    private array $parameters;

    public function __construct(HttpClientInterface $httpClient, ParameterBagInterface $parameterBag)
    {
        $this->httpClient = $httpClient;
        $this->parameters = [
            'apiKey' => $parameterBag->get('app.youtube_api_key'),
            'channelId' => $parameterBag->get('app.youtube_channel_id'),
        ];
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function requestYoutube(int $limit = 12): array
    {
        $response = $this->httpClient->request('GET', 'https://www.googleapis.com/youtube/v3/search', [
            'query' => [
                'part' => 'snippet',
                'channelId' => $this->parameters['channelId'],
                'maxResults' => $limit,
                'order' => 'date',
                'type' => 'video',
                'key' => $this->parameters['apiKey'],
            ],
        ]);

        return $response->toArray();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getLatestVideos(): array
    {
        $data = $this->requestYoutube();

        $videos = [];

        foreach ($data['items'] as $item) {
            $id = $item['id']['videoId'];
            $videos[] = [
                'id' => $id,
                'title' => $item['snippet']['title'],
                'description' => $item['snippet']['description'],
                'thumbnail' => "https://i.ytimg.com/vi/$id/sddefault.jpg",
                'publishedAt' => $item['snippet']['publishedAt'],
            ];
        }

        return $videos;
    }

}
