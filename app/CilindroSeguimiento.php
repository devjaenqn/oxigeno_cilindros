<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CilindroSeguimiento extends Model
{
  protected $table = 'cilindros_seguimiento';
  protected $primaryKey = 'cis_id';
  // protected $hidden = ['created_at', 'updated_at'];

  public function cilindro () {
  	return $this->belongsTo('App\Cilindro', 'cilindro_id');
  }
  public static function eliminar ($cilindro_id, $evento, $referencia_id, $origen) {
    self::where('cilindro_id', $cilindro_id)->where('evento', $evento)->where('referencia_id', $referencia_id)->where('origen', $origen)->first()->delete();
  }
  public function referencia () {
  	switch ($this->evento) {
  		case 'create':
  			return $this->belongsTo('App\Cilindro', 'referencia_id');
  			break;
  		case 'despacho':
  		case 'vacio':
  		case 'cliente':
  		case 'transporte':
  			return $this->belongsTo('App\Despacho', 'referencia_id');
  			break;
  		case 'cargando':
  			return $this->belongsTo('App\Produccion', 'referencia_id');
  			break;
  		case 'cargado':
  			return $this->belongsTo('App\Produccion', 'referencia_id');
  			break;
  		// default:
  		// 	return $this->belongsTo('App\Cilindro', 'referencia_id');
  		// 	break;
  	}
  }

  public static function existe_en_fecha($cilindro_id, $fecha) {
    $temp = self::where('cilindro_id', $cilindro_id)->where('fecha', DB::raw("DATE('".$fecha."')"))->count();
    return $temp > 0;
  }

  public static function extraer_nuevo_orden($cilindro_id, $fecha) {
    $temp = DB::table('cilindros_seguimiento')->select(DB::raw('MAX(orden_seg) as mayor'))->where('cilindro_id', $cilindro_id)->where('fecha', DB::raw("DATE('".$fecha."')"))
      ->first();
    // dd($temp);
    if ($temp)
      return $temp->mayor + 1;
    else return 1;
  }

  protected static function boot() {
    parent::boot();

    static::addGlobalScope('orden_evento', function (Builder $builder) {
        $builder->select(['*', DB::raw('DATE(fecha) as fecha_date')]);
        $builder->join('eventos', 'cilindros_seguimiento.evento', '=', 'eventos.evento_id');

    });
  }
}
