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

  public function cilindros_pendientes () {
    return CilindrosEntradaSalida::byPropietario($this->ent_id)->get();
  }

  public static function  existe ($numero, $documento_id) {
    return self::where('numero', $numero)->where('tipo_doc', $documento_id)->first();
  }
  public function scopeDetalleDeuda ($query) {

  }
  public function scopeAddDeudaCilindro ($query) {
    return $query->selectRaw(
      "(SELECT
        COUNT(es.`cilindro_id`)
        FROM `cilindros_entrada_salida` es
        JOIN despacho guia ON guia.`des_id` = es.guia_id
        WHERE
        es.`completado` = '0' AND
        guia.`entidad_id` = entidades.ent_id

        ) AS cilindros_deuda,
        (SELECT
        MIN(guia.`fecha_emision`)
        FROM `cilindros_entrada_salida` es
        JOIN despacho guia ON guia.`des_id` = es.guia_id
        WHERE
        es.`completado` = '0' AND
        guia.`entidad_id` = entidades.ent_id

        ) AS desde"

    );
  }
  // public function getDocumentoAttribute () {
  //     // return $this->documento->cod;
  //   return 'xxx';
  // }



}
