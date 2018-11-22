<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RolesUsuarios extends Model
{
  protected $table = 'role_user';
  protected $primaryKey = 'id';

  protected $hidden = ['created_at', 'updated_at'];
}
