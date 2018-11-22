<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
  protected $table = 'users';
  protected $primaryKey = 'id';

  protected $hidden = ['created_at', 'updated_at'];

  public static function existe_usuario ($name) {
  	 return self::where('name', $name)->count();

  }

  public function role_usuario () {
    return $this->hasOne('App\RolesUsuarios', 'user_id');
  }

  public function getRole () {
    return $this->role_usuario->role->slug;
  }

  public static function get_usuario_account ($name) {
		return self::where('name', $name)
  		// ->where('password', $password)
  		// ->join('users_data', 'users.id', 'users_data.users_id')
  		->first();

  }
}
