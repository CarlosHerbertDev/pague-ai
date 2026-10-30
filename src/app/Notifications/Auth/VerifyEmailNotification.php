<?php

declare(strict_types=1);

namespace App\Notifications\Auth;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueueAfterCommit;

final class VerifyEmailNotification extends VerifyEmail implements ShouldQueueAfterCommit
{
    use Queueable;
}
