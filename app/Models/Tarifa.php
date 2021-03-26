<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Tarifa extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['*'];

    protected static $logOnlyDirty = true;
    
    protected $fillable = ['time','description','amount','hierarchy','type_id','uuid'];

    protected $table = 'tarifas';

    public function venda()
    {
    	return $this->HasMany(Renta::class);
    }
}
