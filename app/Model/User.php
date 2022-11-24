<?php

declare(strict_types=1);

namespace App\Model;

use App\Request\LoginRequest;
use App\Request\RegisterRequest;
use Components\Hashing\DefaultHasher;
use Components\Auth\JWT;
use Hyperf\Database\Model\SoftDeletes;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * @property int $id 
 * @property string $name 
 * @property int $status 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class User extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'users';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['name', 'email', 'email_verified_at', 'password', 'remember_token', 'profile_photo_path'];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected array $hidden = ['password', 'remember_token', 'deleted_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = [
        'id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * 
     */
    public static function scopeCreateNewAccount($query, LoginRequest|RegisterRequest $request)
    {
        $password = $request->input('password');

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => (new DefaultHasher)->make($password)
        ]);

        return User::authenticated($request);
    }

    /**
     * 
     */
    public static function scopeAuthenticated($query, LoginRequest|RegisterRequest $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = $query->where('email', $email)->first();
        if (!$user) {
            return false;
        }

        $isValidPassword = (new DefaultHasher)->check($password, $user->password);
        if ($isValidPassword) {

            $jwt = new JWT($request, $user);

            return [
                'token' => $jwt->generateToken(),
                'user' => $user,
            ];
        }

        return false;
    }

    /**
     * 
     */
    public static function scopeValidateToken($query, RequestInterface $request)
    {
        $jwt = new JWT($request);

        $token = $jwt->validateToken();

        if (!$token || !$user = $query->find($token->sub)) {
            return false;
        }

        return $user;
    }
}
