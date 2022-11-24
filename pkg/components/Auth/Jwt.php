<?php

namespace Components\Auth;

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

    public Key $key1;
    public Key $key2;

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
        $this->key1 = new Key($this->access_token_secret, $this->algo);
        $this->key2 = new Key($this->refresh_token_secret, $this->algo);
    }

    public function generateToken()
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
            ],
            $this->access_token_secret,
            $this->algo
        );
    }

    protected function generateRefreshToken()
    {
        $jti = $this->jti('sha1');
        return BaseJwt::encode(
            [
                'iss' => $this->request->url(),
                'sub' => $this->user->id,
                'nbf' => $this->currentTime,
                'iat' => $this->currentTime,
                'exp' => $this->expiresAt($this->refresh_ttl),
                'jti' => $jti,
                'scope' => self::REFRESH_TOKEN,
            ],
            $this->access_token_secret,
            $this->algo
        );
    }

    public function validateToken()
    {
        $token = $this->decodeAccessToken();

        $isExpiredToken = $token->exp < time();
        $isInvalidScope = $token->scope != self::ACCESS_TOKEN;
        if ($isExpiredToken || $isInvalidScope) {
            return false;
        }

        return $token;
    }

    public function validateRefreshToken()
    {
        $token = $this->decodeRefreshToken();

        $isExpiredToken = $token->exp < time();
        $isInvalidScope = $token->scope != self::REFRESH_TOKEN;
        if ($isExpiredToken || $isInvalidScope) {
            return false;
        }

        return $token;
    }

    public function decodeAccessToken()
    {
        if (!$bearerToken = $this->bearerToken()) {
            return false;
        }
        
        return $this->decode($bearerToken, $this->key1);
        
    }

    public function decode(string $jwt, Key $key)
    {
        try {
            return BaseJwt::decode($jwt, $key);
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function decodeRefreshToken()
    {
        if (!$bearerToken = $this->bearerToken()) {
            return false;
        }
        
        return $this->decode($bearerToken, $this->key2);
    }

    protected function bearerToken()
    {
        if (preg_match('/Bearer\s(\S+)/', $this->request->header('Authorization'), $matches)) {
            return $matches[1];
        }

        return false;
    }

    protected function expiresAt(int $ttl = null)
    {
        return $this->currentTime + ((int)$ttl * 60);
    }

    protected function jti(string $algo = 'sha1')
    {
        return hash($algo, $this->currentTime . $this->access_token_secret . $this->user->updated_at);
    }
}
