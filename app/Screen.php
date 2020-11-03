<?php

namespace Manticore;

use Illuminate\Database\Eloquent\Model;
use Manticore\Traits\UuidModel;


class Screen extends Model
{
    use UuidModel;

    protected $table = 'screens';

    protected $fillable = [
        'uuid',
        'screen_name',
        'screen_order_number',
        'app_id',
        'app_uuid',
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function app()
    {
        return $this->belongsTo('Manticore\App', 'app_uuid', 'uuid'); // THIS WORKS FOR FINDING THE APP THE SCREEN BELONGS TO!
    }

    public function texts()
    {
        return $this->hasMany('Manticore\Text', 'screen_uuid', 'uuid');
    }

    public function images()
    {
        return $this->hasMany('Manticore\Image', 'screen_uuid', 'uuid');
    }

    public function web_views()
    {
        return $this->hasMany('Manticore\WebView', 'screen_uuid', 'uuid');
    }

    public function buttons()
    {
        return $this->hasMany('Manticore\Button', 'screen_uuid', 'uuid');
    }

    public function buttons_sub_screens()
    {
        return $this->hasMany('Manticore\ButtonSubscreen', 'screen_uuid', 'uuid');
    }

    public function styles()
    {
        return $this->hasMany('Manticore\Style', 'screen_uuid', 'uuid');
    }


    public function button_styles()
    {
        return $this->hasMany('Manticore\ButtonStyle', 'screen_uuid', 'uuid');
    }

    public function text_styles()
    {
        return $this->hasMany('Manticore\TextStyle', 'screen_uuid', 'uuid');
    }


    public function constraints()
    {
        return $this->hasMany('Manticore\Constraint', 'screen_uuid', 'uuid');
    }

    // ADD public functions for custom android/ios components as required.

}
