<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NegocioComprobantes extends Model
{
  protected $table = 'comprobantes_negocio';
  protected $primaryKey = 'cne_id';
  protected $hidden = ['created_at', 'updated_at'];

  public function negocio () {
    return $this->belongsTo('App\Negocio', 'negocio_id');
  }

  public function comprobante () {
    return $this->belongsTo('App\Comprobante', 'comprobante_id', 'cod');
  }

  public function scopeGetDocActivo ($query, $cod) {
    $value = 0;
    switch ($cod) {
      case 'factura': $value = '01'; break;
      case 'guia': $value = '09'; break;
    }
    return $query->where('comprobante_id', $value);
  }
  public function getActivo ($cod) {
    return $this->GetDocActivo($cod)->where('activo', '1')->first();
  }

  public function getActivos () {
    return $this;
  }
  public function hola () {
    return $this->GetDocActivo('factura')->first();
  }

}
