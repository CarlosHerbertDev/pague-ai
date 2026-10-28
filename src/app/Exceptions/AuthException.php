<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Enums\AuthError;
use RuntimeException;

final class AuthException extends RuntimeException
{
    public function __construct(public readonly AuthError $error)
    {
        parent::__construct($error->message());
    }
}