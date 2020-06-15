<?php
declare(strict_types=1);

namespace App;

final class Validator implements ValidatorInterface
{
    protected static $brackets = [
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
        // TODO: Implement validate() method.

        return false;
    }
}