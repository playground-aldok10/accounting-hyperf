<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Controller\Api\V1;

use App\Controller\Api\BaseApiController;
use App\Middleware\JwtAuthMiddleware;
use App\Model\User;
use App\Request\LoginRequest;
use App\Request\RegisterRequest;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;

#[Controller(prefix: 'api/v1/auth')]
class AuthController extends BaseApiController
{
    #[PostMapping(path: 'login')]
    public function login(LoginRequest $request)
    {
        if (! $user = User::authenticated($request)) {
            return $this->responseError(
                message: 'Login failed. Wrong email or password!',
                status: 401
            );
        }

        return $this->response(
            message: 'Login Success',
            data: $user
        );
    }

    #[PostMapping(path: 'register')]
    public function register(RegisterRequest $request)
    {
        if (! $account = User::createNewAccount($request)) {
            return $this->responseError(
                message: 'Registration failed. Please try again.',
                status: 500
            );
        }

        return $this->response(
            message: 'Register Success',
            data: $account,
            status: 201
        );
    }

    #[GetMapping(path: 'me')]
    #[Middleware(JwtAuthMiddleware::class)]
    public function me()
    {
        return $this->response(
            message: 'Success',
            data: $this->container->userData
        );
    }
}