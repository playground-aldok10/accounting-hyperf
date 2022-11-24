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
namespace App\Controller\Grpc;

use App\Controller\AbstractController;
use Grpc\HiReply;
use Grpc\HiUser;

class HiController extends AbstractController
{
    public function sayHello(HiUser $user) 
    {
        
        $message = new HiReply();
        $message->setMessage("Hello World");
        $message->setUser($user);

        return $message;
    }
}
