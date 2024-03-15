<?php

namespace App\Service;

class ValidParentheses
{
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
            if (in_array($item, $this->openToClose, true)) {
                if ($stack->isEmpty() || $this->openToClose[$stack->top()] !== $item) {
                    return false;
                }

                $stack->pop();
            } elseif (array_key_exists($item, $this->openToClose)) {
                $stack->push($item);
            }
        }

        return $stack->isEmpty();
    }
}
