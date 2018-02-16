<?php

namespace Manticore;

use Illuminate\Database\Eloquent\Model;

class GcmUser extends Model
{
    protected $fillable = ['deviceId', 'regId', 'app_uuid'];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function app()
    {
        return $this->belongsTo('Manticore\App', 'app_uuid', 'uuid');
    }
}
