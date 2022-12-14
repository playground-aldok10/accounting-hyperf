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
use Hyperf\Contract\StdoutLoggerInterface;
use Psr\Log\LogLevel;

return [
    'app_env' => env('APP_ENV', 'dev'),
    'app_name' => env('APP_NAME', 'skeleton'),
    'app_key' => env('APP_KEY', ''),
    'server_name' => env('SERVER_NAME', 'Hyperf'),

    /**
     * JWT Configuration
     */
    'jwt' => [
        'access_token_secret' => env('ACCESS_TOKEN_SECRET', 'hyperf'),
        'refresh_token_secret' => env('REFRESH_TOKEN_SECRET', 'hyperf'),
        'algo' => env('JWT_ALGO', 'HS256'),
        'ttl' => (int) env('JWT_TTL', 60),
        'refresh_ttl' => (int) env('JWT_REFRESH_TTL', 20160),
    ],

    /**
     * Hashing Secret Key
     */
    'hashing' => [
        'default' => [
            'rounds' => (int) env('HASH_ROUNDS', 8),
            'salt' => env('HASH_SALT', 'sEcr3tH@shS4lT!!!'),
        ]
    ],
    'scan_cacheable' => env('SCAN_CACHEABLE', false),
    StdoutLoggerInterface::class => [
        'log_level' => [
            // LogLevel::DEBUG,
            LogLevel::ALERT,
            LogLevel::CRITICAL,
            LogLevel::EMERGENCY,
            LogLevel::ERROR,
            LogLevel::INFO,
            LogLevel::NOTICE,
            LogLevel::WARNING,
        ],
    ],
];
