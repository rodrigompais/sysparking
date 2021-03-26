<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Veiculo extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['*'];

    protected static $logOnlyDirty = true;
    
    protected $fillable = ['plate','model','color','brand','type_id','uuid'];

    protected $table = 'carriers';
}
