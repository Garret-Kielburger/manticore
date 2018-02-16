<?php

namespace Manticore;

use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    protected $table = 'navigations';

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',

    ];

    public function apps()
    {
        return $this->hasMany('Manticore\App');
    }

/*    public function id()
    {
        return $this->app()->wherePivot();
    }*/


}
