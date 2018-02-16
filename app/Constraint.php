<?php

namespace Manticore;

use Illuminate\Database\Eloquent\Model;
use Manticore\Traits\UuidModel;

class Constraint extends Model
{
    use UuidModel;

    protected $table = 'constraints';

    protected $fillable = [
        'uuid',
        'screen_uuid',
        'button_sub_screen_uuid',
        'start_id',
        'start_side',
        'end_id',
        'end_side',
        'margin',
        'horizontally_centered',

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
        // which image/text is irrelevant becasue it gets parsed by the client mobile app
        return $this->belongsTo('Manticore\Screen', 'screen_uuid', 'uuid');
    }
}
