<?php
declare(strict_types=1);

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use function App\isValid;

final class FunctionTest extends TestCase
{
    public function testCannotBeEmptyString(): void
    {
        static::assertFalse(isValid(''));
    }

    public function testCannotBeNotClosed(): void
    {
        static::assertFalse(isValid('{{'));
    }

    public function testCannotBeClosedAndOpen(): void
    {
        static::assertFalse(isValid('}{'));
    }
}
