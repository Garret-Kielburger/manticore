<?php

namespace Manticore;

use Illuminate\Database\Eloquent\Model;
use Manticore\Traits\UuidModel;

class ButtonSubscreen extends Model
{
    use UuidModel;

    protected $table = 'buttons_sub_screens';

    protected $fillable = [
        'uuid',
        'screen_uuid',
        'owning_button_uuid',
        'title',
        'purpose',
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

    public function app()
    {
        return $this->belongsTo('Manticore\App', 'app_uuid', 'uuid'); // THIS WORKS FOR FINDING THE APP THE SCREEN BELONGS TO!
    }

    public function texts()
    {
        return $this->hasMany('Manticore\Text', 'button_sub_screen_uuid', 'uuid');
    }

    public function images()
    {
        return $this->hasMany('Manticore\Image', 'button_sub_screen_uuid', 'uuid');
    }

    public function buttons()
    {
        return $this->hasMany('Manticore\Button', 'button_sub_screen_uuid', 'uuid');
    }

}
