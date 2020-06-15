<?php
declare(strict_types=1);

namespace App\Tests;

use App\Validator;
use App\ValidatorInterface;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    protected static Validator $instance;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$instance = new Validator();
    }

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();

        self::$instance = null;
    }

    public function testValidateInstanceOf(): void
    {
        static::assertInstanceOf(ValidatorInterface::class, $this->instance);
    }

    public function testCannotBeEmptyString(): void
    {
        static::assertFalse(self::$instance->validate(''));
    }
}
