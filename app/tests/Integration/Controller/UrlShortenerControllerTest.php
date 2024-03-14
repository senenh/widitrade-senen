<?php

namespace App\Tests\Integration\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UrlShortenerControllerTest extends WebTestCase
{
    public function testValidUrl(): void
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/v1/url-shortener',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => 'Bearer []',
            ],
            json_encode(['url' => 'https://www.google.es/search?sca_esv=3c0cd88929cc7700&q=gatos+en+el+espacio&tbm=isch&source=lnms&sa=X&ved=2ahUKEwivkLnlseyEAxWRUaQEHU9sAgYQ0pQJegQICRAB&biw=1728&bih=959&dpr=2'])
        );

        $this->assertResponseIsSuccessful();
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('url', $responseData);
    }

    public function testInvalidUrl(): void
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/v1/url-shortener',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => 'Bearer []',
            ],
            json_encode(['url' => 'invalid-url'])
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('This value is not a valid URL.', $responseData['errors']['url']);
    }

    public function testMissingUrl(): void
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/v1/url-shortener',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => 'Bearer []',
            ],
            json_encode([])
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('This value should not be blank.', $responseData['errors']['url']);
    }

    public function testUnauthorizedAccess(): void
    {
        $client = $this->createClient();
        $client->request(
            'POST',
            '/api/v1/url-shortener',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => 'Bearer invalid_token',
            ],
            json_encode(['url' => 'https://www.example.com'])
        );

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $client->getResponse()->getStatusCode());
    }
}
