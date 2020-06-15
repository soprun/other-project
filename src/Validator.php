<?php
declare(strict_types=1);

namespace App;

use InvalidArgumentException;
use RuntimeException;
use SplStack;
use Throwable;

final class Validator implements ValidatorInterface
{
    protected static array $brackets = [
        '{' => '}',
        '[' => ']',
        '(' => ')',
    ];

    private bool $debug;

    public function __construct(bool $debug = false)
    {
        $this->debug = $debug;
    }

    public function validate(string $input): bool
    {
        try {
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
                        'An error occurred and requires an open bracket.'
                    );
                }

                if ($stack->pop() !== $character) {
                    throw new RuntimeException(
                        'An error occurred and requires a closed bracket.'
                    );
                }
            }

            if ($stack->count() > 0) {
                throw new RuntimeException(
                    'An error occurred and not all brackets are closed.'
                );
            }

            return true;
        } catch (Throwable $exception) {
            return false;
        }
    }
}