<?php

namespace App\Tests\Providers\TinyUrl;

use App\Providers\TinyUrl\ApiClient;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiClientTest extends TestCase
{
    public function testCreateShortenedUrl(): void
    {
        // Arrange
        $originalUrl = 'https://www.example.com';
        $expectedTinyUrl = 'https://tiny.url/example';
        $expectedResponseData = json_encode(['data' => ['tiny_url' => $expectedTinyUrl]], JSON_THROW_ON_ERROR);

        $mockResponse = new MockResponse($expectedResponseData, [
            'http_code' => 200,
            'response_headers' => ['Content-Type: application/json'],
        ]);

        $mockHttpClient = new MockHttpClient($mockResponse);
        $apiClient = new ApiClient($mockHttpClient, 'correct_api_token');

        // Act
        $tinyUrl = $apiClient->createShortenedUrl($originalUrl);

        // Assert
        $this->assertEquals($expectedTinyUrl, $tinyUrl);
    }

    public function testCreateShortenedUrlUnauthorized(): void
    {
        // Arrange
        $originalUrl = 'https://www.example.com';
        $errorResponse = [
            'data' => [],
            'code' => 1,
            'errors' => [
                'Unauthorized',
            ],
        ];
        $expectedErrorResponse = json_encode($errorResponse, JSON_THROW_ON_ERROR);

        $mockResponse = new MockResponse($expectedErrorResponse, [
            'http_code' => Response::HTTP_UNAUTHORIZED,
            'response_headers' => ['Content-Type: application/json'],
        ]);

        $mockHttpClient = new MockHttpClient($mockResponse);
        $apiClient = new ApiClient($mockHttpClient, 'wrong_api_token');

        // Act and Assert
        $this->expectException(ClientException::class);
        $apiClient->createShortenedUrl($originalUrl);
    }
}
