<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
  protected $table = 'lotes';
  protected $primaryKey = 'lot_id';

  protected $hidden = ['created_at', 'updated_at'];

  public function sistema () {
    return $this->belongsTo('App\Sistema', 'sistema_attr', 'attr');
  }

  public function scopeActivo ($query) {
    return $query->where('activo', 1);
  }

  public function scopeOneActivo ($query) {
    return $query->where('activo', 1);
  }
}
