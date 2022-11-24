<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Model\User;
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
        if(!$user = User::validateToken($this->request)){
            return $this->response->json(
                [
                    'status' => 0,
                    'message' => 'Invalid Token',
                    'data' => [
                        'error' => 'The token is invalid, preventing further execution.',
                    ],
                ]
            );
        };

        $this->container->userData = $user;

        return $handler->handle($request);
    }
}
