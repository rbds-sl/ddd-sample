<?php

declare(strict_types=1);

namespace CoverManager\Shared\Framework\Infrastructure\Logging;

use CoverManager\Shared\Framework\Helpers\MixedHelper;

use function get_class;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Sentry\State\Scope;
use Throwable;

final class LoggerHelper
{
    public static ?string $lastError = null;

    public static function logException(Throwable $exception): void
    {
        Log::error($exception->getMessage());
        if (app()->bound('sentry')) {
            \Sentry\configureScope(function (Scope $scope): void {
                $scope->setTag('CoverManager.userId', MixedHelper::getString(Auth::id()));
                $scope->setTag('CoverManager.userType', Auth::user() ? get_class(Auth::user()) : '');
            });
            app('sentry')->configureScope(static function (Scope $scope) {
                $scope->setTag('CoverManager.userId', MixedHelper::getString(Auth::id()));
                $scope->setTag('CoverManager.userType', Auth::user() ? get_class(Auth::user()) : '');
            });
            app('sentry')->captureException($exception);
        }
        self::$lastError = $exception->getMessage();
    }

    public static function logInfo(string $message): void
    {
        Log::error($message);
    }

    public static function resetError(): void
    {
        self::$lastError = null;
    }
}
