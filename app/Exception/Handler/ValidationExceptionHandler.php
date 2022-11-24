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
namespace App\Exception\Handler;

use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class ValidationExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->stopPropagation();
        
        if (! $response->hasHeader('content-type')) {
            $response = $response->withAddedHeader('content-type', 'application/json; charset=utf-8');
        }

        /** @var \Hyperf\Validation\ValidationException $throwable */
        $errors = $throwable->validator->errors();
        $body = ['status' => 0, 'error_code' => 400, 'errors' => $errors];

        return $response->withHeader('Server', config('server_name'))->withStatus(400)->withBody(new SwooleStream(json_encode($body)));
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof ValidationException;
    }
}
