<?php

namespace App\Tests\Unit\Security;

use App\Security\CustomTokenExtractor;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class CustomTokenExtractorTest extends TestCase
{
    /**
     * @dataProvider tokenDataProvider
     */
    public function testExtractValidToken(string $token, ?string $expectedToken): void
    {
        $request = Request::create('/', 'GET', [], [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer '.$token,
        ]);

        $extractor = new CustomTokenExtractor();
        $token = $extractor->extractAccessToken($request);

        $this->assertEquals($expectedToken, $token);
    }

    public function testNoTokenInRequest(): void
    {
        $request = Request::create('/', 'GET');
        $extractor = new CustomTokenExtractor();
        $token = $extractor->extractAccessToken($request);

        $this->assertNull($token);
    }

    /**
     * @return array<array{string, string|null}>
     */
    public function tokenDataProvider(): array
    {
        return [
            ['{}', '{}'],
            ['{}[]()', '{}[]()'],
            ['{)', '{)'],
            ['[{a]}', null],
            ['asdg', null],
        ];
    }
}
