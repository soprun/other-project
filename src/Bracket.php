<?php
declare(strict_types=1);

namespace App;

use InvalidArgumentException;
use RuntimeException;
use SplStack;

final class Bracket
{
    private static array $brackets = [
        '{' => '}',
        '[' => ']',
        '(' => ')',
    ];

    public static function isValid(string $input): bool
    {
        if (empty($input) === true) {
            throw new InvalidArgumentException(
                'An error occurred and the string cannot be empty.'
            );
        }

        $data = str_split($input);

        if ((count($data) % 2 === 0) === false) {
            throw new InvalidArgumentException(
                'An error occurred and the number of comparisons is incorrect.'
            );
        }

        $stack = new SplStack();

        foreach ($data as $character) {
            if (array_key_exists($character, self::$brackets) === true) {
                $stack->push(self::$brackets[$character]);
                continue;
            }

            if ($stack->count() === 0) {
                throw new RuntimeException(
                    "An error occurred and requires an open bracket."
                );
            }

            if ($stack->pop() !== $character) {
                throw new RuntimeException(
                    "An error occurred and requires a closed bracket."
                );
            }
        }

        if ($stack->count() > 0) {
            throw new RuntimeException(
                'An error occurred and not all brackets are closed.'
            );
        }

        return true;
    }
}