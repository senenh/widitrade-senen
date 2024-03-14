<?php

namespace App\Tests\Unit\Service;

use App\Service\ValidParentheses;
use PHPUnit\Framework\TestCase;

class ValidParenthesesTest extends TestCase
{
    /**
     * @dataProvider parenthesesDataProvider
     */
    public function testIsValid(string $string, bool $expected): void
    {
        $validParentheses = new ValidParentheses();
        $result = $validParentheses->isValid($string);
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array<array{string, bool}>
     */
    public function parenthesesDataProvider(): array
    {
        return [
            ['{}', true],
            ['{}[]()', true],
            ['{)', false],
            ['[{]}', false],
            ['{([])}', true],
            ['(((((((()', false],
            ['', false],
        ];
    }
}
