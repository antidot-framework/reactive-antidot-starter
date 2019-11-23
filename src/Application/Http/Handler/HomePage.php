<?php

declare(strict_types=1);

namespace App\Application\Http\Handler;

use Antidot\React\PSR15\Response\PromiseResponse;
use App\Application\Event\SomeEvent;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use React\Promise\FulfilledPromise;
use Zend\Diactoros\Response\JsonResponse;

class HomePage implements RequestHandlerInterface
{
    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $promise = new FulfilledPromise($request);

        return new PromiseResponse(
            $promise
                ->then(function (ServerRequestInterface $request) {
                    $this->eventDispatcher->dispatch(SomeEvent::occur());
                    return $request;
                })
                ->then(function (ServerRequestInterface $request) {
                    return new JsonResponse([
                        'docs' => 'https://antidotfw.io',
                        'message' => $request->getAttribute('foo') . ' Welcome to Antidot Framework Starter',
                    ]);
                })
        );
    }
}
