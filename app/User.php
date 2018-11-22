<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at'
    ];
    public static function existe_usuario ($name, $password) {
        return self::where('name', $name)
            ->where('password', $password)->count();
    }



    public static function get_usuario_account ($name, $password) {
            return self::where('name', $name)
            // ->where('password', $password)
            // ->join('users_data', 'users.id', 'users_data.users_id')
            ->get();

    }
}
