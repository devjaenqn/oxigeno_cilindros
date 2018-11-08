<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentosIdentidad extends Model
{
  protected $table = 'documentos_identidad';
  protected $primaryKey = 'doc_id';
  public $timestamps = false;

  protected $fillable = [
    'definicion', 'corto', 'persona', 'estado', 'cod'
  ];

  public function propietarios () {
    return $this->hasMany('App\Propietarios', 'tipo_doc', 'doc');
  }
}
