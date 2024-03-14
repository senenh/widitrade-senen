<?php

namespace App\Providers\TinyUrl;

use App\Providers\ApiClientInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiClient implements ApiClientInterface
{
    private const BASE_API_URL = 'https://api.tinyurl.com';

    public function __construct(
        private HttpClientInterface $client,
        private string $apiToken,
    ) {
    }

    public function createShortenedUrl(string $originalUrl): string
    {
        $response = $this->client->request(
            'POST',
            self::BASE_API_URL.'/create?api_token='.$this->apiToken,
            [
                'json' => ['url' => $originalUrl],
            ]
        );
        $responseArray = $response->toArray();

        return $responseArray['data']['tiny_url'];
    }
}
