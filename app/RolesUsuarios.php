<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RolesUsuarios extends Model
{
  protected $table = 'role_user';
  protected $primaryKey = 'id';

  protected $hidden = ['created_at', 'updated_at'];


  public function role () {
    return $this->belongsTo('App\Roles', 'role_id');
  }

  public function usuario () {
    return $this->belongsTo('App\Usuario', 'user_id');
  }
}
