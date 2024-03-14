<?php

namespace App\Providers;

interface ApiClientInterface
{
    public function createShortenedUrl(string $originalUrl): string;
}
