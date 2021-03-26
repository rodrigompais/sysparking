<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class CustomerCarrier extends Model
{
    use LogsActivity;
    
    protected static $logAttributes = ['*'];

    protected static $logOnlyDirty = true;
    
    protected $fillable = ['user_id','carrier_id','uuid'];

    protected $table = 'customercarriers';

}
