<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\AccessToken\AccessTokenExtractorInterface;

class CustomTokenExtractor implements AccessTokenExtractorInterface
{
    private string $regex;

    public function __construct(
        private readonly string $headerParameter = 'Authorization',
        private readonly string $tokenType = 'Bearer'
    ) {
        $this->regex = sprintf(
            '/^%s([\[\]\{\}\(\)]+)$/',
            '' === $this->tokenType ? '' : preg_quote($this->tokenType, null).'\s+'
        );
    }

    public function extractAccessToken(Request $request): ?string
    {
        if (!$request->headers->has($this->headerParameter) || !\is_string($header = $request->headers->get($this->headerParameter))) {
            return null;
        }

        if (preg_match($this->regex, $header, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
