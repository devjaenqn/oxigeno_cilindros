<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produccion extends Model
{
  protected $table = 'produccion';
  protected $primaryKey = 'pro_id';

  protected $hidden = ['created_at', 'updated_at'];

  public function detalles () {
    return $this->hasMany('App\ProduccionCilindros', 'produccion_id');
  }


  public function lote () {
    return $this->belongsTo('App\Lote', 'lote_id');
  }

  public function operador () {
    return $this->belongsTo('App\Operador', 'operador_id');
  }

  public function scopeSoloActivos ($query) {
    return $query->where('eliminado', 0);
  }
  // public function scopeActivo ($query) {
  //   return $query->where('activo', 1);
  // }

  // public function scopeOneActivo ($query) {
  //   return $query->where('activo', 1);
  // }
}
