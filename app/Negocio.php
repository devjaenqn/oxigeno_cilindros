<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//comentario
class Negocio extends Model
{
  protected $table = 'negocios';
  protected $primaryKey = 'neg_id';

  protected $hidden = ['created_at', 'updated_at'];

  protected $cod = '';
  protected $filter_data = ['activo' => false, 'comprobante' => false];

  public function comprobantes () {
    $res = $this->hasMany('App\NegocioComprobantes', 'negocio_id');
    if ($this->filter_data['activo']) {
      $res->where('activo', '1');
    }

    if ($this->filter_data['comprobante']) {
      $res->where('comprobante_id', $this->cod);
    }
    return $res;
  }

  public function baseGetDocumentosActivos () {
    return $this->comprobantes->where('activo' , '1');
  }
  public function getDocumentoActivo ($cod) {
    $value = 0;
    switch ($cod) {
      case 'factura': $value = '01'; break;
      case 'guia': $value = '09'; break;
    }
    return $this->baseGetDocumentosActivos()->where('comprobante_id', $value)->first();
  }
  public function getDocumentosActivos ($cod) {
    $value = 0;
    switch ($cod) {
      case 'factura': $this->cod = '01'; break;
      case 'guia': $this->cod = '09'; break;
    }
    return $this->comprobantes;
  }
  public function setDefaultFilter () {
    $this->filter_data['activo'] = false;
    $this->filter_data['comprobante'] = false;
    $this->cod = '';
  }
  public function setDocumentosActivos ($cod) {
    $this->filter_data['activo'] = true;
    $this->filter_data['comprobante'] = true;
    switch ($cod) {
      case 'factura': $this->cod = '01'; break;
      case 'guia': $this->cod = '09'; break;
      case 'recibo': $this->cod = 'crec'; break;
    }
    return $this;
  }
}
