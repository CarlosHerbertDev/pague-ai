<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\ResendVerificationEmailAction;
use App\Actions\Auth\VerifyEmailAction;
use App\Enums\AuthError;
use App\Exceptions\AuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\EmailRequest;
use App\Support\FrontendUrl;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class EmailVerificationController extends Controller
{
    public function verify(Request $request, string $id, string $hash, VerifyEmailAction $action): RedirectResponse
    {
        if (! $request->hasValidSignature()) {
            return redirect()->away(FrontendUrl::to('/login', ['error' => AuthError::InvalidVerificationLink->value]));
        }

        try {
            $action->execute($id, $hash);
        } catch (AuthException $e) {
            return redirect()->away(FrontendUrl::to('/login', ['error' => $e->error->value]));
        }

        return redirect()->away(FrontendUrl::to('/login', ['verified' => '1']));
    }

    public function resend(EmailRequest $request, ResendVerificationEmailAction $action): JsonResponse
    {
        $action->execute($request->normalizedEmail());

        return response()->json([
            'message' => 'Se o e-mail estiver cadastrado e ainda não confirmado, enviaremos um novo link.',
        ]);
    }
}