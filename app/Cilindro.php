<?php

namespace App;

use App\CilindroSeguimiento;
use Illuminate\Database\Eloquent\Model;

class Cilindro extends Model
{
  //SITUACION  0, perdido, 1-fabrica, 2-transporte, 3-cliente
  //ESTADO 0-vacio, 1-cargando, 2-cargado
  //Comentario agregado
  protected $table = 'cilindros';
  protected $primaryKey = 'cil_id';
  protected $fillable = [
    'serie', 'codigo', 'capacidad', 'tapa',
    'presion', 'propietario_id', 'situacion', 'cargado', 'defectuoso', 'evento'
  ];
  protected $hidden = ['created_at', 'updated_at'];

  protected $casts = [
    'cargado' => 'string'
  ];

  public function temporal () {
    return $this->hasOne('App\CilindroTemporal', 'cilindro_id');
  }
  public function propietario () {
    // return $this->belongsTo('App\Propietarios', 'ent_id', 'propietario_id');
    return $this->belongsTo('App\Propietarios', 'propietario_id');
  }

  public function entidad () {
    return $this->belongsTo('App\Propietarios', 'propietario_id');
  }

  public function seguimiento () {
    return $this->hasMany('App\CilindroSeguimiento', 'cilindro_id');
  }

  public function escopeExisteCodigo ($query, $codigo) {
    return $query->where('codigo', $codigo);
  }

  public function getEventos () {
    $detalles =  CilindroSeguimiento::where('cilindro_id', $this->cil_id);
    return $detalles;
    // $detalles =  CilindroSeguimiento::where('cilindro_id', $this->cil_id)
    //               ->orderBy('fecha', 'desc');
    // return $detalles;
  }
  public function entrada_salida () {
    return $this->hasMany('App\CilindrosEntradaSalida', 'cilindro_id');
  }

  public function getEventosFecha () {
    $detalles =  CilindroSeguimiento::where('cilindro_id', $this->cil_id)
                  ->orderBy('fecha', 'desc')->orderBy('orden', 'asc');
    return $detalles;
  }
  public function getKardex ($fecha_desde, $fecha_hasta) {
    // $this->getEventosFecha()
    //   ->where()
  }
  public function getUltimoEvento ($saltar = 0) {

    $ultimo = $this->getEventos();
    // $count = $this->getEventos()->count();

    if ($saltar >= 0) {
      // if ($saltar <= $count) {
      $ultimo->offset($saltar)->limit(1);
      // }
    }
    return $ultimo;
  }

  public function getUltimoEventoApp ($saltar = 0) {

    $ultimo = $this->getEventos()->whereIn('origen', ['app', 'forzado'])
      ->orderBy('orden', 'asc')
      ->orderBy('fecha_detalle', 'asc');
    // $count = $this->getEventos()->count();
    // dd($ultimo->get()->toArray());
    if ($saltar >= 0) {
      // if ($saltar <= $count) {
      $ultimo->offset($saltar)->limit(1);
      // }
    }
    return $ultimo;
  }





  public static function existeCodigo ($propietario, $codigo) {
   return Cilindro::where('codigo', $codigo)
    ->where('propietario_id', $propietario)
    ->first();
  }

  public static function getBySerie ($codigo) {
    return self::where('serie', $codigo)->first();
  }
  public static function getEstado ($name) {
    switch ($name) {
      case 'vacio': return '0';
      case 'cargando': return '1';
      case 'cargado': return '2';
      case 'defectuoso': return '1';
      case 'optimo': return '0';
      default: return '-1';
    }
  }

  public static function getSituacion ($name) {
    switch ($name) {
      case 'perdido': return '0';
      case 'fabrica': return '1';
      case 'transporte': return '2';
      case 'cliente': return '3';
      default: return '-1';
    }
  }
}
