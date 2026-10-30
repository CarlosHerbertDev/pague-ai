<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('auth', fn (Request $request): Limit => Limit::perMinute(10)->by($request->ip()));

        VerifyEmail::toMailUsing(fn(object $notifiable, string $url): MailMessage => (new MailMessage)
            ->subject('Confirme seu e-mail no Pague AI')
            ->greeting("Olá, {$notifiable->name}!")
            ->line('Clique no botão abaixo para confirmar seu e-mail.')
            ->action('Confirmar e-mail', $url)
            ->line('O link vale por 60 minutos. Se você não criou uma conta, ignore este e-mail.'));
    }
}
