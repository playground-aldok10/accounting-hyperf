<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Model\User;
use Hyperf\Context\Context;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;

class JwtAuthMiddleware implements MiddlewareInterface
{
    /**
     * Coroutine-local context key used to store the authenticated user for the
     * lifetime of the current request.
     */
    public const USER_CONTEXT_KEY = 'auth.user';

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var HttpResponse
     */
    protected $response;

    public function __construct(ContainerInterface $container, HttpResponse $response, RequestInterface $request)
    {
        $this->container = $container;
        $this->response = $response;
        $this->request = $request;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$user = User::validateToken($this->request)) {
            return $this->response->json(
                [
                    'status' => 0,
                    'message' => 'Invalid Token',
                    'data' => [
                        'error' => 'The token is invalid, preventing further execution.',
                    ],
                ]
            )->withStatus(401);
        }

        // Store the authenticated user in the coroutine-local context so it is
        // not shared across concurrent requests (the container is a singleton
        // and was previously leaking one user's data into other requests).
        Context::set(self::USER_CONTEXT_KEY, $user);

        return $handler->handle($request->withAttribute(self::USER_CONTEXT_KEY, $user));
    }
}
