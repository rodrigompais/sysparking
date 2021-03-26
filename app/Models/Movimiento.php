<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Movimiento extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['*'];

    protected static $logOnlyDirty = true;
    
    protected $table = 'cashdesk';

    protected $fillable = ['amount','description','receipt','type','user_id','uuid'];
}
