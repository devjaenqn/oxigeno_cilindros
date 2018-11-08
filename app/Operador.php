<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Operador extends Model
{
  protected $table = 'operador';
  protected $primaryKey = 'ope_id';
  // protected $fillable = [
  //   'nombre',
  //   'apellidos',
  //   'direccion',
  //   'fecha_nacimiento',
  //   'dni', 'estado'
  // ];
  protected $visible = ['nombre', 'apellidos', 'direccion'];
  protected $hidden = ['created_at', 'updated_at'];
}
