<?php

namespace Manticore;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{

    protected $table = 'members';

    protected $fillable = [
        'email',
        'username',
        'password',
        'app_uuid',
        'expiry',
    ];

    protected $hidden = [
        'id',
    ];

    public function app()
    {
        return $this->belongsTo('Manticore\App', 'app_uuid', 'uuid');
     //   return $this->belongsTo('Manticore\App', 'app_uuid', 'uuid'); // THIS WORKS FOR SCREENS
    }

}
