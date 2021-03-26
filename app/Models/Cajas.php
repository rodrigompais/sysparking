<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cajas extends Model
{
    protected $fillable = ['monto','tipo','concepto','comprobante','user_id','uuid'];
}
