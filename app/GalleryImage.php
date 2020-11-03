<?php

namespace Manticore;

use Illuminate\Database\Eloquent\Model;
use Manticore\Traits\UuidModel;

class GalleryImage extends Model
{
    use UuidModel;

    protected $table = 'gallery_images';

    protected $fillable = [

        'uuid',
        'app_uuid',
        'uri',
        'delete_uri',

    ];

    protected $hidden = [

        'id',
        'delete_uri',
        'created_at',
        'updated_at',

    ];

    public function app()
    {
        return $this->belongsTo('App\App', 'app_uuid', 'uuid');
    }
}
