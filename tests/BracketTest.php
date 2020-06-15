<?php

namespace App\Tests;

use App\Bracket;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Throwable;

final class BracketTest extends TestCase
{
    protected Bracket $instance;

    public function testCannotBeEmptyString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('An error occurred and the string cannot be empty.');

        $this->instance->isValid('');
    }

    public function patternProvider(): array
    {
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
        ];
    }

    /**
     * @param string $input
     * @param bool $compare
     * @dataProvider patternProvider
     */
    public function testIsValid(string $input, bool $compare): void
    {
        try {
            $check = $this->instance->isValid($input);
        } catch (Throwable $exception) {
            $check = false;

            echo $exception->getMessage();
        }

        static::assertSame($check, $compare, $input);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->instance = new Bracket(false);
    }
}
