<?php

namespace Manticore;

use Illuminate\Database\Eloquent\Model;
use Manticore\Traits\UuidModel;

class Style extends Model
{
    use UuidModel;

    protected $table = 'styles';

    protected $fillable = [
        'uuid',
        'screen_uuid',
        'button_sub_screen_uuid',
        'view_object_uuid',
        'property_to_style',
        'value_to_apply',
    ];

    protected $hidden = [
        'id',
        'uuid',
        'button_sub_screen_uuid',
        'created_at',
        'updated_at',

    ];

    public function screen()
    {
        return $this->belongsTo('Manticore\Screen', 'screen_uuid', 'uuid');
    }

    public function saved_property()
    {
        return $this->hasOne('Manticore\PropertyToStyle', 'id', 'property_to_style');
    }

/*    public function saved_value()
    {
        $intValue = $this->property_to_style;
        if ($intValue . intValue()) {
            return $intValue;
        } else {
            $value = FontStyleValue::where('property_to_style', $this->property_to_style)->pluck('id');
            if ($value) {
                return $value;
            }
        }
    }*/

    public function getStringValue()
    {
        return $this->belongsTo('Manticore/FontStyleValue');
    }


}
