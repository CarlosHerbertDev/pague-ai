<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Models\User;

final class ResendVerificationEmailAction
{
    public function execute(string $email): void
    {
        $user = User::query()->where('email', $email)->first();

        if ($user !== null && ! $user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
        }
    }
}