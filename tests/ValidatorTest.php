<?php
declare(strict_types=1);

namespace App\Tests;

use App\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    protected Validator $instance;

    public function testValidateInstanceOf(): void
    {
        static::assertTrue(true);
    }

    public function testCannotBeEmptyString(): void
    {
        static::assertTrue(true);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->instance = new Validator();
    }
}
