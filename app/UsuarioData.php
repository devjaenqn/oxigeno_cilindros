<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioData extends Model
{
  protected $table = 'users_data';
  protected $primaryKey = 'du_id';
  public $timestamps = false;

  public function user () {
    return $this->belongsTo('App\Usuario', 'users_id');
  }

}
