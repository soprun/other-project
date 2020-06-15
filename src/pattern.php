<?php
declare(strict_types=1);

return [
    ['{', false],
    ['}', false],
    ['{}', true],
    ['()', true],
    ['[]', true],
    ['}{', false],
    [')(', false],
    ['][', false],
    ['{{}', false],
    ['{}}', false],
    ['{{}}', true],
    ['{}()[]', true],
    ['{{}()[]}', true],
    ['{{}(()[])}', true],
    ['{{}(({)[}])}', false],
    ['{[()([]<>)]}', false],
];
