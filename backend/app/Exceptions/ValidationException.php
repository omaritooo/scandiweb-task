<?php

namespace App\Exceptions;

class ValidationException extends \Exception
{
    public static function because(string $message = "", int $code = 422): static
    {
        return new static($message, $code);
    }
}
