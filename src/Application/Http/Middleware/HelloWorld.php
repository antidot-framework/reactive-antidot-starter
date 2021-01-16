<?php

declare(strict_types=1);

namespace App\Application\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class HelloWorld implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $greet = $request->getQueryParams()['greet'] ?? 'World';
        $request = $request->withAttribute('greet', $greet);

        return $handler->handle($request);
    }
}
