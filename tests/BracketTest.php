<?php
declare(strict_types=1);

namespace App\Tests;

use App\Bracket;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Throwable;

final class BracketTest extends TestCase
{
    public function testCannotBeEmptyString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('An error occurred and the string cannot be empty.');

        Bracket::isValid('');
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
            ['{[()([]<>)]}', false],
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
            $check = Bracket::isValid($input);
        } catch (Throwable $exception) {
            $check = false;
        }

        static::assertSame($check, $compare, $input);
    }
}
