<?php
declare(strict_types=1);

namespace App\Tests;

use App\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    /**
     * @param string $input
     * @param bool $expect
     * @dataProvider validateDataProvider
     */
    public function testValidate(string $input, bool $expect): void
    {
        $instance = new Validator();

        static::assertSame(
            $expect,
            $instance->validate($input),
            (string)printf('Failed asserting that "%s" matches expected true.', $input)
        );
    }

    public function validateDataProvider(): array
    {
        return [
            'sad' => ['{}', true]
        ];
    }
}
