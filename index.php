<?php
declare(strict_types=1);

use App\Bracket;

require __DIR__ . '/vendor/autoload.php';

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
    '{[()([]<>)]}' => false,
    '{[()([<]<>>)]}' => false,
];

foreach ($pattern as $rule => $compare) {
    try {
        $check = Bracket::isValid($rule);
    } catch (Throwable $exception) {
        $check = false;
    }

    var_dump($check === $compare);
}