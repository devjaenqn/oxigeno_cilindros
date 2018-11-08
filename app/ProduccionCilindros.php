<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProduccionCilindros extends Model
{
  protected $table = 'produccion_cilindros';
  protected $primaryKey = 'pci_id';

  protected $fillable = ['produccion_id', 'cilindro_id', 'pro_capacidad', 'pro_presion'];
  protected $hidden = ['created_at', 'updated_at'];

  public function cilindro () {
    return $this->belongsTo('App\Cilindro', 'cilindro_id');
  }

  public function produccion () {
    return $this->belongsTo('App\Produccion', 'produccion_id');
  }

}
