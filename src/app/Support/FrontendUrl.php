<?php

declare(strict_types=1);

namespace App\Support;

final class FrontendUrl
{
    public static function to(string $path, array $query = []): string
    {
        $url = rtrim((string) config('app.frontend_url'), '/').$path;

        return $query === [] ? $url : $url.'?'.http_build_query($query);
    }
}