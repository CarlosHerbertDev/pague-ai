<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\RegisterUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

final class AuthController extends Controller
{
    public function register(RegisterRequest $request, RegisterUserAction $action): JsonResponse
    {
        return (new UserResource($action->execute($request->toData())))
            ->additional(['message' => 'Conta criada. Enviamos um link de confirmação para o seu e-mail.'])
            ->response()
            ->setStatusCode(201);
    }
}