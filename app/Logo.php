<?php

namespace Manticore;

use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    protected $table = 'logos';

    public function app()
    {
        return $this->belongsTo('Manticore\App');
    }

}
