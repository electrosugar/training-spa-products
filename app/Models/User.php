<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'email',
        'password'
    ];

    public $timestamps = false;

    public $username;
    public $password;

    /**
     * User constructor.
     * @param string $username
     * @param string $password
     */
    public function create(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }
}
