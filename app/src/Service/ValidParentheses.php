<?php

namespace App\Service;

class ValidParentheses
{
    /** @var string[] */
    private array $openChars = ['(', '{', '['];

    /** @var string[] */
    private array $closeChars = [')', '}', ']'];

    /** @var array<string, string> */
    private array $openToClose = [
        '(' => ')',
        '{' => '}',
        '[' => ']',
    ];

    public function isValid(string $string): bool
    {
        if (empty($string)) {
            return false;
        }

        $array = str_split($string);
        $stack = new \SplStack();

        foreach ($array as $item) {
            if (in_array($item, $this->closeChars, true)) {
                if ($stack->isEmpty() || $this->openToClose[$stack->top()] !== $item) {
                    return false;
                }

                $stack->pop();
            } elseif (in_array($item, $this->openChars, true)) {
                $stack->push($item);
            }
        }

        return $stack->isEmpty();
    }
}
