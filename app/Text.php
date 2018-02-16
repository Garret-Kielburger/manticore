<?php

namespace Manticore;

use Illuminate\Database\Eloquent\Model;
use Manticore\Traits\UuidModel;

class Text extends Model
{
    use UuidModel;

    protected $table = 'texts';

    protected $fillable = [
        'uuid',
        'screen_uuid',
        'button_sub_screen_uuid',   // belongs to a button click
        'screen_id',
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
