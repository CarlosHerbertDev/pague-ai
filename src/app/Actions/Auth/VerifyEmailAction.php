<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Enums\AuthError;
use App\Exceptions\AuthException;
use App\Models\User;
use Illuminate\Auth\Events\Verified;

final class VerifyEmailAction
{
    public function execute(string $userId, string $hash): void
    {
        $user = User::query()->find($userId);

        if ($user === null || ! hash_equals(sha1($user->getEmailForVerification()), $hash)) {
            throw new AuthException(AuthError::InvalidVerificationLink);
        }

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();

            event(new Verified($user));
        }
    }
}