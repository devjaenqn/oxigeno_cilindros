<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Despacho extends Model
{

  protected $table = 'despacho';
  protected $primaryKey = 'des_id';

  protected $hidden = ['created_at', 'updated_at'];


  public function detalles () {
    return $this->hasMany('App\DespachoCilindros', 'despacho_id');
  }

  public function detallesdos () {
    return $this->hasMany('App\DespachoCilindros', 'despacho_id');
  }



  public function guia () {
    return $this->belongsTo('App\NegocioComprobantes', 'documento_id');
  }

  public function documento () {
    return $this->belongsTo('App\NegocioComprobantes', 'documento_id');
  }

  public function destino () {
    return $this->belongsTo('App\PropietariosLocacion', 'destino_id');
  }
  public static function getByNumeroAndDoc ($documento, $numero) {
    return self::where('doc_numero', $numero)->where('documento_id', $documento)->first();
  }
  public static function existe_numero ($documento, $numero) {
    $res = false;
    $find = self::where('doc_numero', '=', fill_zeros($numero))
              ->where('documento_id', '=', $documento)
              ->get();
    foreach ($find as $value) {
      if (+$value->doc_numero == +$numero) {
        $res = true;
        break;
      }

    }
    return $res;
  }
  public function origen () {
    return $this->belongsTo('App\PropietariosLocacion', 'destino_id');
  }
  public function cliente () {
    return $this->belongsTo('App\Propietarios', 'entidad_id');
  }
  public function getProcesos($proceso) {
    // $this->documento->comprobante->com_id
    // $this->documento->comprobante->cod
  }

  public function format_documento() {
    return $this->doc_serie.'-'.$this->doc_numero;
  }
  public function scopeBala ($query) {
    return $query->where('destino_id', 33);
  }
  public static  function xx() {
    return '0asdasd';
  }
  public  function scopeGetAllByProceso($query, $codigo_documento) {
    return $query
      ->where('comprobantes_negocio.comprobante_id', $codigo_documento)
      ->join('comprobantes_negocio', 'despacho.documento_id', '=', 'comprobantes_negocio.cne_id');
  }
}
