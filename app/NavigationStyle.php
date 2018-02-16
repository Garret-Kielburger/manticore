<?php

namespace Manticore;

use Illuminate\Database\Eloquent\Model;
use Manticore\Traits\UuidModel;

class NavigationStyle extends Model
{
    use UuidModel;

    protected $table = 'navigation_styles';

    protected $fillable = [
        'uuid',
        'app_uuid',
        'start_colour',
        'end_colour',
        'background_colour',
        'title',
        'subtitle',
        'text_colour',
        'text_highlight_colour',
    ];

    protected $hidden = [
        'id',
        'uuid',
        'app_uuid',
        'created_at',
        'updated_at',

    ];

    public function app()
    {
        return $this->belongsTo('Manticore\App', 'app_uuid', 'uuid');
    }


}
