<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DespachoCilindros extends Model
{

  protected $table = 'despacho_cilindros';
  protected $primaryKey = 'dci_id';

  // protected $fillable = ['produccion_id', 'cilindro_id', 'pro_capacidad', 'pro_presion'];
  protected $hidden = ['created_at', 'updated_at'];

  public function cilindro () {
    return $this->belongsTo('App\Cilindro', 'cilindro_id');
  }

  public function despacho () {
    return $this->belongsTo('App\Despacho', 'despacho_id');
  }

  public function propietario () {
    return $this->belongsTo('App\Propietarios', 'propietario_id');
  }
}
