<?php

namespace App;

use App\PropietariosLocacion;
use Illuminate\Database\Eloquent\Model;

class PropietariosLocacion extends Model
{

  protected $table = 'entidades_locacion';
  protected $primaryKey = 'elo_id';

  protected $hidden = ['created_at', 'updated_at'];

  public function entidad () {
    return $this->belongsTo('App\Propietarios', 'entidad_id');
  }

  public static function existeLocacion ($propietario, $locacion, $agregar = false) {

    $temp =  PropietariosLocacion::where('locacion', $locacion)
    ->where('entidad_id', $propietario)
    ->first();
    if ($agregar) {
      if ($temp == null) {
          $temp = new PropietariosLocacion();
          $temp->entidad_id = $propietario;
          $temp->locacion = strtoupper($locacion);
          $temp->predeterminado = '0';
          $temp->save();
      }
    }
    return $temp;
  }
}
