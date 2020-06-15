<?php
declare(strict_types=1);

use App\Validator;

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

$instance = new Validator();

foreach ($pattern as $rule => $comparison) {
    $compare = $instance->validate($rule) === $comparison;

    printf("# '%s' - %s \n", $rule, $compare ? 'ok' : 'err');
}