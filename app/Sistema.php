<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sistema extends Model
{
  protected $table = 'sistemas';
  protected $primaryKey = 'sis_id';
  // protected $fillable = [
  //   'nombre',
  //   'apellidos',
  //   'direccion',
  //   'fecha_nacimiento',
  //   'dni', 'estado'
  // ];
  protected $visible = ['sistema', 'attr', 'sis_id'];
  protected $hidden = ['created_at', 'updated_at'];

  public function lotes () {
    return $this->hasMany('App\Lote', 'sistema_attr', 'attr');
  }

  public function lote () {
    return $this->hasOne('App\Lote', 'sistema_attr', 'attr')->activo();
  }

  public function oneLote () {
    return $this->hasMany('App\Lote', 'sistema_attr', 'attr')->oneActivo();
  }
}
