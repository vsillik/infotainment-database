<?php

declare(strict_types=1);

namespace App\Filters\Exceptions;

class InvalidFilterValueException extends \ValueError
{
    public readonly string $filterName;

    public function __construct(string $filterName, string $message = '', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->filterName = $filterName;
    }
}
