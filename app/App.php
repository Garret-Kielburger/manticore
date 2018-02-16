<?php

namespace Manticore;

use Illuminate\Database\Eloquent\Model;
use Manticore\Traits\UuidModel;


class App extends Model
{
    use UuidModel;

    protected $table = 'apps';

    protected $fillable = [
        'uuid',
        'app_name',
        'app_api_key',
        'user_id',
        'user_uuid',
        'screen_id',
        'screen_uuid',
        'navigation_id',
        'action_bar_colour',
        'system_bar_colour',

    ];

    protected $hidden = [
        'id',
        'app_api_key',
        'created_at',
        'updated_at',
    ];


    public function screens()
    {
        return $this->hasMany('Manticore\Screen', 'app_uuid', 'uuid'); // WORKS WITH FINDING APP's SCREENS
    }

    public function subscreens()
    {
        return $this->hasMany('Manticore\ButtonSubscreen','app_uuid', 'uuid');
    }

    public function user()
    {
        return $this->belongsTo('Manticore\User', 'user_uuid', 'uuid'); // WORKS!
    }

    public function navigation()
    {
        return $this->belongsTo('Manticore\Navigation', 'navigation_id', 'id');
    }

    public function navigation_style()
    {
        return $this->hasOne('Manticore\NavigationStyle', 'app_uuid', 'uuid');
    }

    public function logo()
    {
        return $this->hasOne('Manticore\Logo');
    }

    public function gcmusers()
    {
        return $this->hasMany('Manticore\GcmUser', 'app_uuid', 'uuid');
    }

    public function members()
    {
        return $this->hasMany('Manticore\Member','app_uuid', 'uuid'); // anticipating problems with this - uuid might not be needed
    }

}

// Call all texts etc from App:

// $test = App\App::with('screens.texts')->with('screens.images')->where('id',1)->get();

// Elements in one:
// $grid = Manticore\Screen::with('texts')->with('images')->where('uuid', $screen->uuid)->get();


// ChimeraTestApp Firebase id => 1:625158631590:android:d07b778813a87189
// Server Key - AIzaSyCVdciQn2c72NAccm1187ewIxUqPyk6ENo
// Sender Id  - 625158631590