<?php

namespace Components\JWT;

use App\Model\User;
use Firebase\JWT\JWT as BaseJwt;
use Firebase\JWT\Key;
use Hyperf\HttpServer\Contract\RequestInterface;

class JWT
{    
    public const TYPE = 'Bearer';
    public const TOKEN_TYPE = ['ACCESS_TOKEN', 'REFRESH_TOKEN'];
    public const ACCESS_TOKEN = 'ACCESS_TOKEN';
    public const REFRESH_TOKEN = 'REFRESH_TOKEN';

    public Key $key;

    public function __construct(
        RequestInterface $request = new RequestInterface,
        User $user = new User
    ) {
        foreach(config('jwt') as $propKey => $propValue){
            $this->{$propKey} = $propValue;
        }

        $this->currentTime = time();
        $this->request = $request;
        $this->user = $user;
        $this->key = new Key($this->access_token_secret, $this->algo);
    }

    public function encode()
    {
        return [
            'type' => self::TYPE,
            'access_token' => $this->generateAccessToken(),
            'refresh_token' => $this->generateRefreshToken(),
            'expires_at' => $this->expiresAt($this->ttl)
        ];
    }

    protected function generateAccessToken()
    {
        $jti = $this->jti('haval160,4');
        return BaseJwt::encode(
            [
                'iss' => $this->request->url(),
                'sub' => $this->user->id,
                'nbf' => $this->currentTime,
                'iat' => $this->currentTime,
                'exp' => $this->expiresAt($this->ttl),
                'jti' => $jti,
                'scope' => self::ACCESS_TOKEN,
                'at_hash' => $this->atHash('md4', $jti)
            ],
            $this->access_token_secret,
            $this->algo
        );
    }

    protected function generateRefreshToken()
    {
        $jti = $this->jti('sha512');
        return BaseJwt::encode(
            [
                'iss' => $this->request->url(),
                'sub' => $this->user->id,
                'nbf' => $this->currentTime,
                'iat' => $this->currentTime,
                'exp' => $this->expiresAt($this->refresh_ttl),
                'jti' => $jti,
                'scope' => self::REFRESH_TOKEN,
                'at_hash' => $this->atHash('sha1', $jti)
            ],
            $this->access_token_secret,
            $this->algo
        );
    }

    protected function expiresAt(int $ttl = null)
    {
        return $this->currentTime + ((int)$ttl * 60);
    }

    protected function jti(string $algo = 'sha1')
    {
        return hash($algo, $this->currentTime . $this->access_token_secret . $this->user->updated_at);
    }

    protected function atHash(string $algo = 'sha1', string $jti = '')
    {
        return hash($algo, $jti . $this->user->email . $this->user->updated_at);
    }
}
