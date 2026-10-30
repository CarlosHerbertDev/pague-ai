<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Data\Auth\RegisterUserData;
use App\Enums\AuthError;
use App\Exceptions\AuthException;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;

final class RegisterUserAction
{
    public function execute(RegisterUserData $data): User
    {
        return DB::transaction(function () use ($data): User {
            $existing = User::query()->where('email', $data->email)->first();

            if ($existing !== null) {
                throw new AuthException($existing->hasPassword()
                    ? AuthError::EmailAlreadyRegistered
                    : AuthError::EmailRegisteredWithGoogle);
            }

            $user = User::query()->create([
                'name' => $data->name,
                'email' => $data->email,
                'password' => $data->password,
            ]);

            event(new Registered($user));

            return $user;
        });
    }
}
