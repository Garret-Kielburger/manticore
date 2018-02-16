<?php

namespace Manticore;

use Illuminate\Database\Eloquent\Model;
use Manticore\Traits\UuidModel;

class WebView extends Model
{
    use UuidModel;

    protected $table = 'web_views';

    protected $fillable = [
        'uuid',
        'screen_uuid',
        'web_address',

    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function screen()
    {
        return $this->belongsTo('Manticore\Screen', 'screen_uuid', 'uuid'); // belongsTo('Manticore\App', 'screen_uuid') --> eventually?
    }

}
