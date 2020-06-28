<?php

declare(strict_types=1);

namespace App\Application\Http\Handler;

use Antidot\React\PSR15\Response\PromiseResponse;
use App\Application\Event\SomeEvent;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

use function React\Promise\resolve;

class HomePage implements RequestHandlerInterface
{
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $eventDispatcher = $this->eventDispatcher;
        return new PromiseResponse(
            resolve($request)
                ->then(static function (ServerRequestInterface $request) use ($eventDispatcher) {
                    $eventDispatcher->dispatch(SomeEvent::occur());
                    return $request;
                })
                ->then(static function (ServerRequestInterface $request) {
                    return new JsonResponse([
                        'docs' => 'https://antidotfw.io',
                        'message' => $request->getAttribute('foo') . ' Welcome to Antidot Framework Starter',
                    ]);
                })
        );
    }
}
