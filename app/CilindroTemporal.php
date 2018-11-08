<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CilindroTemporal extends Model
{
  protected $table = 'cilindros_temporales';
	protected $primaryKey = 'ciltemp_id';
	protected $hidden = ['created_at', 'updated_at'];
}
