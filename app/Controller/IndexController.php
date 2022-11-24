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
namespace App\Controller;

use App\Model\Category;

class IndexController extends AbstractController
{
    public function index()
    {
        // $user = $this->request->input('user', 'Hyperf');
        // $method = $this->request->getMethod();

        // $categories = Category::all();
        return [
            // 'method' => $method,
            // 'data' => $categories,
            // 'message' => "Hello {$user}.",
        ];
    }

    public function hello()
    {
        // This client is coroutine-safe and can be reused
        $client = new \App\Grpc\HiClient('127.0.0.1:9503', [
            'credentials' => null,
        ]);

        $name = $this->request->input('name', 'Hyperf');

        $request = new \Grpc\HiUser();
        $request->setName((string) $name);
        $request->setSex(1);

        /**
        * @var \Grpc\HiReply $reply
        */
        list($reply, $status) = $client->sayHello($request);

        $message = $reply->getMessage();
        $user = $reply->getUser();
        
        return [
            'message' => $message,
            'name' => $user->getName(),
            'sex' => $user->getSex(),
            'status' => $status,
            'allocate_memory' => self::convert(memory_get_usage()),
            'real_allocate_memory' => self::convert(memory_get_usage(true))
        ];
    }

    protected static function convert($size)
    {
        $unit=array('b','kb','mb','gb','tb','pb');
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
    }
}
