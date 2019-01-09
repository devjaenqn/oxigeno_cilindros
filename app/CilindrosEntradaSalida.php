<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CilindrosEntradaSalida extends Model
{
  protected $table = 'cilindros_entrada_salida';
  protected $primaryKey = 'ces_id';
  protected $hidden = ['created_at', 'updated_at'];

  public static function getSinCompletar ($cilindro_id) {
  	return self::where('cilindro_id', $cilindro_id)
  							->where('completado', '0')->orderBy('salida', 'desc')->first();
  }
  public static function getDespachoSalida ($cilindro_id, $despacho_id) {
    return self::where('cilindro_id', $cilindro_id)
                ->where('guia_id', $despacho_id)
                ->where('completado', '0')->orderBy('salida', 'desc')->first();
  }
  public function guia () {
  	return $this->belongsTo('App\Despacho', 'guia_id');
  }

  public  function scopeByPropietario ($query, $propietario_id) {
    return $query->select(
      'des_id', 'doc_serie', 'doc_numero', 'entidad_id', 'fecha_emision', 'destino_nombre', 'cilindro_id'
    )->where('entidad_id', $propietario_id)
      ->join('despacho', 'despacho.des_id', 'cilindros_entrada_salida.guia_id');
  }

  public function recibo () {
  	return $this->belongsTo('App\Despacho', 'recibo_id');
  }

  public function cilindro () {
   return $this->belongsTo('App\Cilindro', 'cilindro_id');
  }


}
