<?php

function isValid(string $input): bool
{
    try {
        static $brackets = [
            '{' => '}',
            '[' => ']',
            '(' => ')',
            '<' => '>',
        ];

        $length = mb_strlen($input);

        if ($length < 2) {
            throw new Exception(
                'An error occurred and the string length does not match the expected length.'
            );
        }

        $stack = new SplStack();

        foreach (str_split($input) as $current => $symbol) {
            if (array_key_exists($symbol, $brackets) === true) {
                $stack->push($brackets[$symbol]);
                continue;
            }

            if ($stack->count() === 0) {
                throw new RuntimeException('Validation error occurred, no open brackets.');
            }

            if ($stack->pop() !== $symbol) {
                throw new LengthException(
                    "An error occurred and the symbol {$current} requires a closed bracket of the same type."
                );
            }
        }

        if ($stack->count() > 0) {
            throw new RuntimeException(
                "There are {$stack->count()} open brackets left."
            );
        }
    } catch (Exception $exception) {
        return false;
    }

    return true;
}

$pattern = [
    '' => false,
    '{' => false,
    '}' => false,
    '}{' => false,
    '{}' => true,
    '{{}}' => true,
    '{()}' => true,
    '}(){' => false,
    '{)(}' => false,
    '{}.' => false,
    '.{}.' => false,
    '{()[]<>}' => true,
    '{()([]<>)}' => true,
    '{[()([]<>)]}' => true,
    '{[()([<]<>>)]}' => false,
];

echo PHP_EOL;

foreach ($pattern as $input => $compare) {
    echo "'{$input}' | ";
    echo isValid($input) === $compare ? 'success..' : 'failure';
    echo PHP_EOL;
}
