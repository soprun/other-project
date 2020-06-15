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
    protected bool $debug;

    public function __construct(bool $debug = false)
    {
        $this->debug = $debug;
    }

    public function isValid(string $input): bool
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

        foreach ($data as $current => $character) {
            if ($this->isOpen($character) === true) {
                $closed = $this->getClosed($character);
                $stack->push($closed);
                continue;
            }

            if ($stack->count() === 0) {
                throw new RuntimeException(
                    "An error occurred and the character {$current} requires an open bracket."
                );
            }

            if ($stack->pop() !== $character) {
                throw new RuntimeException(
                    "An error occurred and the character {$current} requires a closed bracket."
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

    protected function isOpen(string $input): bool
    {
        return array_key_exists($input, self::$brackets) === true;
    }

    protected function getClosed(string $input): string
    {
        return self::$brackets[$input];
    }
}