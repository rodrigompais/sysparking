<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Tipo extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['*'];

    protected static $logOnlyDirty = true;

    protected $fillable = ['description', 'uuid','imagem'];

    protected $table = 'types';
}
