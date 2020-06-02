<?php
declare(strict_types=1);

function isValid(string $input): bool
{
    static $brackets = [
        '{' => '}',
        '[' => ']',
        '(' => ')',
        '<' => '>',
    ];

    $data = str_split($input);

    if (count($data) < 2) {
        throw new LengthException(
            'An error occurred and string length does not match the expected.'
        );
    }

    $stack = new SplStack();

    foreach ($data as $current => $value) {
        if (array_key_exists($value, $brackets) === true) {
            $stack->push($brackets[$value]);
            continue;
        }

        if ($stack->count() === 0) {
            throw new RuntimeException(
                "An error occurred and the character {$current} requires an open bracket."
            );
        }

        if ($stack->pop() !== $value) {
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

foreach ($pattern as $input => $compare) {
    echo PHP_EOL . "'{$input}' | ";

    try {
        if (isValid($input) !== $compare) {
            throw new RuntimeException('lol kek xD');
        }
        echo 'success..';
    } catch (Throwable $exception) {
        echo 'failure..';
        // echo $exception->getMessage();
    }
}
