<?php

namespace Manticore;

use Illuminate\Database\Eloquent\Model;
use Manticore\Traits\UuidModel;

class Button extends Model
{
    use UuidModel;

    protected $table = 'buttons';

    protected $fillable = [
        'uuid',
        'screen_uuid',              // belongs to a screen
        'button_sub_screen_uuid',   // belongs to a button click/subscreen
        'with_sub_screen',
        'sub_screen_uuid',          // subscreen clicking this button goes to
        'label',
        'purpose',
        'content',
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function screen()
    {
        return $this->belongsTo('Manticore\Screen', 'screen_uuid', 'uuid'); // belongsTo('Manticore\App', 'screen_uuid') ----> eventually
    }

    public function subscreen()
    {
        return $this->belongsTo('Manticore\ButtonSubscreen', 'button_sub_screen_uuid', 'uuid');
    }


}
