<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Propietarios extends Model
{
  protected $table = 'entidades';
  protected $primaryKey = 'ent_id';
  protected $fillable = [
    'nombre',
    'numero',
    'tipo_doc',
    'direccion',
    'telefono', 'referencia', 'correo',
  ];
  protected $hidden = ['created_at', 'updated_at'];
  // protected $visible = ['documento'];
  public function documento () {
    return $this->belongsTo('App\DocumentosIdentidad', 'tipo_doc', 'cod');
  }

  public function locaciones () {
    return $this->hasMany('App\PropietariosLocacion', 'entidad_id');
  }

  public static function  existe ($numero, $documento_id) {
    return self::where('numero', $numero)->where('tipo_doc', $documento_id)->first();
  }

  // public function getDocumentoAttribute () {
  //     // return $this->documento->cod;
  //   return 'xxx';
  // }



}
