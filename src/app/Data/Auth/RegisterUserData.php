<?php

declare(strict_types=1);

namespace App\Data\Auth;

final readonly class RegisterUserData
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {}
}