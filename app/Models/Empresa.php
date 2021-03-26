<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Empresa extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['*'];

    protected static $logOnlyDirty = true;
    
    protected $fillable = [
        'uuid',
        'address_cep',
        'address_full',
        'address_number',
        'address_complement',
        'address_district',
        'address_city',
        'address_uf',
        'name',
        'telephone',
        'email',
        'logo'
    ];

    protected $table = 'companies';
}