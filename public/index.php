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

# Pattern
# The rule.
# .

foreach ($pattern as $rule => $comparison) {
    // $compare
    var_dump(isValid($rule) === $comparison);
}