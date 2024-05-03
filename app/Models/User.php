<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Authenticatable implements AuthenticatableContract
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password', 'permission', 'verification_token', 'token_expires_at'];

    protected $hidden = ['password'];

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public static function buscaPeloEmail($email)
    {
        return static::where('email', $email)->first();
    }

    public static function buscaPeloEmailESenha($email, $senha)
    {
        $user = static::where('email', $email)->first();

        if ($user && Hash::check($senha, $user->password)) {
            return $user;
        }

        return null;
    }

    public function isAdmin()
    {
        return $this->permission === 'admin';
    }
}
