<?php

namespace Manticore;

use Illuminate\Database\Eloquent\Model;
use Manticore\Traits\UuidModel;

class ButtonStyle extends Model
{
    use UuidModel;

    protected $table = 'button_styles';

    protected $fillable = [
        'uuid',
        'screen_uuid',
        'button_sub_screen_uuid',
        'view_object_uuid',
        'text_size',
        'text_color',
        'text_style',
        'font_family',
        'background_color',

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
        return $this->belongsTo('App\Screen', 'screen_uuid', 'uuid');
    }
}
