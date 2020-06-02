<?php
declare(strict_types=1);

function isValid(string $input, bool $debug = false): bool
{
    static $brackets = [
        '{' => '}',
        '[' => ']',
        '(' => ')',
        '<' => '>',
    ];

    $data = str_split($input);

    try {

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
    } catch (Throwable $exception) {
        if ($debug === true) {
            throw new LogicException(
                'lol ...',
                123,
                $exception
            );
        }

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

foreach ($pattern as $input => $compare) {
    $value = 'failure..';

    if (isValid($input) === $compare) {
        $value = 'success..';
    }

    printf("# '%s' - %s\n", $input, $value);
}

# '' - success..
# '{' - success..
# '}' - success..
# '}{' - success..
# '{}' - success..
# '{{}}' - success..
# '{()}' - success..
# '}(){' - success..
# '{)(}' - success..
# '{}.' - success..
# '.{}.' - success..
# '{()[]<>}' - success..
# '{()([]<>)}' - success..
# '{[()([]<>)]}' - success..
# '{[()([<]<>>)]}' - success..
