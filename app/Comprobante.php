<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comprobante extends Model
{

  protected $table = 'comprobantes';
  protected $primaryKey = 'com_id';

  protected $hidden = ['created_at', 'updated_at'];

  public static function getCode ($nombre) {
    switch ($nombre) {
      case 'factura': return '01';
      case 'guia':    return '09';
      case 'recibo':  return 'crec';
      default: return 'undefined';
    }
  }

}
