<?php

declare(strict_types=1);

namespace App\Enums;

enum AuthError: string
{
    case InvalidCredentials = 'INVALID_CREDENTIALS';
    case EmailNotVerified = 'EMAIL_NOT_VERIFIED';
    case EmailAlreadyRegistered = 'EMAIL_ALREADY_REGISTERED';
    case EmailRegisteredWithGoogle = 'EMAIL_REGISTERED_WITH_GOOGLE';
    case EmailRegisteredWithPassword = 'EMAIL_REGISTERED_WITH_PASSWORD';
    case AccountUsesGoogle = 'ACCOUNT_USES_GOOGLE';
    case GoogleEmailNotVerified = 'GOOGLE_EMAIL_NOT_VERIFIED';
    case GoogleAuthFailed = 'GOOGLE_AUTH_FAILED';
    case InvalidGoogleCode = 'INVALID_GOOGLE_CODE';
    case InvalidRefreshToken = 'INVALID_REFRESH_TOKEN';
    case RefreshTokenReused = 'REFRESH_TOKEN_REUSED';
    case InvalidVerificationLink = 'INVALID_VERIFICATION_LINK';
    case InvalidResetToken = 'INVALID_RESET_TOKEN';

    public function status(): int
    {
        return match ($this) {
            self::InvalidCredentials,
            self::InvalidGoogleCode,
            self::InvalidRefreshToken,
            self::RefreshTokenReused => 401,
            self::EmailNotVerified => 403,
            self::EmailAlreadyRegistered,
            self::EmailRegisteredWithGoogle,
            self::EmailRegisteredWithPassword,
            self::AccountUsesGoogle => 409,
            self::GoogleEmailNotVerified,
            self::GoogleAuthFailed,
            self::InvalidVerificationLink,
            self::InvalidResetToken => 422,
        };
    }

    public function message(): string
    {
        return match ($this) {
            self::InvalidCredentials => 'E-mail ou senha incorretos.',
            self::EmailNotVerified => 'Confirme seu e-mail antes de entrar. Verifique sua caixa de entrada.',
            self::EmailAlreadyRegistered => 'Este e-mail já está cadastrado. Faça login ou recupere sua senha.',
            self::EmailRegisteredWithGoogle => 'Este e-mail já está cadastrado com o Google. Entre com o Google ou use "Esqueci minha senha" para criar uma senha.',
            self::EmailRegisteredWithPassword => 'Já existe uma conta com este e-mail. Entre com e-mail e senha.',
            self::AccountUsesGoogle => 'Esta conta foi criada com o Google. Entre com o Google ou use "Esqueci minha senha" para criar uma senha.',
            self::GoogleEmailNotVerified => 'Seu e-mail do Google não está verificado.',
            self::GoogleAuthFailed => 'Não foi possível entrar com o Google. Tente novamente.',
            self::InvalidGoogleCode => 'Código de login do Google inválido ou expirado.',
            self::InvalidRefreshToken => 'Sua sessão expirou. Faça login novamente.',
            self::RefreshTokenReused => 'Sessão encerrada por segurança. Faça login novamente.',
            self::InvalidVerificationLink => 'Link de confirmação inválido ou expirado.',
            self::InvalidResetToken => 'Link de redefinição inválido ou expirado.',
        };
    }
}