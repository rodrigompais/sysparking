<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Venda extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['*'];

    protected static $logOnlyDirty = true;
    
    protected $fillable = ['acceso','hours','departure','plate','model','color','brand','keys','total',
    'money','change','user_id','carrier_id','tarifa_id','bar_code','status','description','vacancy_id','nota','uuid'];

    protected $table = 'sales';

    public function tarifa()
    {
        return $this->belongsTo(Tarifa::class);
    }
}
