<?php
declare(strict_types=1);

namespace App;

require dirname(__DIR__) . '/vendor/autoload.php';

$pattern = [
    '{' => false,
    '}' => false,
    '{}' => true,
    '()' => true,
    '[]' => true,
    '}{' => false,
    ')(' => false,
    '][' => false,
    '{{}' => false,
    '{}}' => false,
    '{{}}' => true,
    '{}()[]' => true,
    '{{}()[]}' => true,
    '{{}(()[])}' => true,
    '{{}(({)[}])}' => false,
    '{[()([]<>)]}' => false,
];

foreach ($pattern as $rule => $compare) {
    var_dump(isValid($rule) === $compare);
}