<?php

namespace Manticore;

use Illuminate\Database\Eloquent\Model;
use Manticore\Traits\UuidModel;


class Image extends Model
{
    use UuidModel;

    protected $table = 'images';

    protected $fillable = [
        'uuid',
        'screen_uuid',
        'button_sub_screen_uuid',   // belongs to a button click
        'screen_id',
        'purpose',
        'width',
        'height',
        'uri',
        'vertical_align',
        'delete_uri',
    ];

    protected $hidden = [
        'id',
        'delete_uri',
        'created_at',
        'updated_at',
    ];

    public function screen()
    {
        return $this->belongsTo('Manticore\Screen', 'screen_uuid', 'uuid');    // belongsTo('Manticore\App', 'screen_uuid') ----> eventually
    }

    public function subscreen()
    {
        return $this->belongsTo('Manticore\ButtonSubscreen', 'button_sub_screen_uuid', 'uuid');
    }

}
