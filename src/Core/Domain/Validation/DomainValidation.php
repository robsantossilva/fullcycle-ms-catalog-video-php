<?php

namespace Core\Domain\Validation;

use Core\Domain\Exception\EntityValidationException;

class DomainValidation
{
    static public function notNUll(string $value, string $exceptionMessage = null)
    {
        if (empty($value))
            throw new EntityValidationException($exceptionMessage ?? 'Should not be empty');
    }

    static public function strMaxLength(string $value, int $length = 255, string $exceptionMessage = null)
    {
        if (strlen($value) > $length)
            throw new EntityValidationException($exceptionMessage ?? "The value must not be greater than {$length} characters");
    }

    static public function strMinLength(string $value, int $length = 2, string $exceptionMessage = null)
    {
        if (strlen($value) < $length)
            throw new EntityValidationException($exceptionMessage ?? "The value must not be less than {$length} characters");
    }

    static public function strCanBeNullOrMaxLength(string $value = '', int $length = 255, string $exceptionMessage = null)
    {
        if (!empty($value) && strlen($value) > $length)
            throw new EntityValidationException($exceptionMessage ?? "The value must not be greater than {$length} characters");
    }
}
