<?php

declare(strict_types=1);

use Antidot\Application\Http\Application;
use Antidot\React\PSR15\Middleware\ErrorMiddleware;
use Antidot\React\PSR15\Middleware\ExceptionLoggerMiddleware;
use Antidot\React\PSR15\Middleware\RequestLoggerMiddleware;
use Antidot\React\PSR15\Middleware\RouteDispatcherMiddleware;
use Antidot\React\PSR15\Middleware\RouteNotFoundMiddleware;

return static function (Application $app) : void {
    $app->pipe(ErrorMiddleware::class);
    $app->pipe(ExceptionLoggerMiddleware::class);
    $app->pipe(RequestLoggerMiddleware::class);
    $app->pipe(RouteDispatcherMiddleware::class);
    $app->pipe(RouteNotFoundMiddleware::class);
};
