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
use App\Model\User;
use App\Request\LoginRequest;
use App\Request\RegisterRequest;
use Components\Hashing\DefaultHasher;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\PostMapping;

#[Controller(prefix: 'api/v1/auth')]
class AuthController extends BaseApiController
{
    #[Inject]
    protected DefaultHasher  $hash;

    #[PostMapping(path: 'login')]
    public function login(LoginRequest $request)
    {   
        if(!$user = User::authenticated($request)){
            return $this->responseError('Login failed. Wrong email or password!');
        }

        return $this->response(
            message: 'Login Success',
            data: $user
        );
    }

    #[PostMapping(path: 'register')]
    public function register(RegisterRequest $request)
    {
        $password = $request->input('password');

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $this->hash->make($password)
        ]);

        $user = User::authenticated($request);

        return $this->response(
            message: 'Registes Success',
            data: $user
        );
    }
}