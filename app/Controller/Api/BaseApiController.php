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
namespace App\Controller\Api;

use App\Controller\AbstractController;
use Psr\Http\Message\ResponseInterface;

class BaseApiController extends AbstractController
{
    protected function response(
        $data = null,
        string|null $message = null,
        array $additonal_data = [],
        int $status = 200
    ): ResponseInterface
    {
        // Transform response data
        $data = [
            'status' => 1,
            'message' => $message,
            'data' => $data,
            ...$additonal_data
        ];

        return $this->response->json($data)->withStatus($status);
    }

    protected function responseError(
        $data = null,
        string|null $message = null,
        array $additonal_data = [],
        int $status = 400
    ): ResponseInterface
    {
        return $this->response(
            data: $data,
            message: $message,
            additonal_data: ['status' => 0, ...$additonal_data],
            status: $status,
        );
    }
}