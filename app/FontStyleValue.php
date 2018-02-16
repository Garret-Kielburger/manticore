<?php

namespace Manticore;

use Illuminate\Database\Eloquent\Model;

class FontStyleValue extends Model
{
    protected $table = 'font_style_values';

    protected $fillable = [
        'value_to_apply',
        'property_type',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public function styles()
    {
        return $this->belongsTo('Manticore/Style', 'property_value');
    }

}
