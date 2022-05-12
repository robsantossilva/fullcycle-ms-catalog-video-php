<?php

namespace Tests\Unit\Domain\Validation;

use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Validation\DomainValidation;
use PHPUnit\Framework\TestCase;

class DomainValidationUnitTest extends TestCase
{
    public function testNotNull()
    {
        try {
            $value = '';
            DomainValidation::notNUll($value);

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

    public function testNotNullCustomExceptionMessage()
    {
        try {
            $value = '';
            DomainValidation::notNUll($value, 'custom message error');

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals('custom message error', $th->getMessage());
        }
    }

    public function testStrMaxLength()
    {
        try {
            $value = 'custom';
            DomainValidation::strMaxLength($value, 5);

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals("The value must not be greater than 5 characters", $th->getMessage());
        }
    }

    public function testStrMinLength()
    {
        try {
            $value = 'cust';
            DomainValidation::strMinLength($value, 5);

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals("The value must not be less than 5 characters", $th->getMessage());
        }
    }

    public function testCanBeNullOrMaxLength()
    {
        try {
            $value = 'custom';
            DomainValidation::strCanBeNullOrMaxLength($value, 5);

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals("The value must not be greater than 5 characters", $th->getMessage());
        }

        $value = '';
        DomainValidation::strCanBeNullOrMaxLength($value, 5, 'Custom Message');
    }
}
