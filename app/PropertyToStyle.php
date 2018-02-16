<?php

namespace Manticore;

use Illuminate\Database\Eloquent\Model;

class PropertyToStyle extends Model
{
    protected $table = 'properties_to_style';

    protected $fillable = [
        'property_to_style',
    ];

    protected $hidden = [
        'id',
        'element_type',
        'created_at',
        'updated_at',
    ];


    public function styles()
    {
        return $this->hasMany('Manticore/Style');
    }


}
