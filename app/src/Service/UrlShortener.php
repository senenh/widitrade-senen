<?php

namespace App\Service;

use App\Providers\TinyUrl\ApiClient as TinyUrlShortener;

class UrlShortener
{
    public function __construct(
        private TinyUrlShortener $client
    ) {
    }

    public function shortenUrl(string $originalUrl): string
    {
        return $this->client->createShortenedUrl($originalUrl);
    }
}
