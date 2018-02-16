<?php

namespace Manticore;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Manticore\Traits\UuidModel;

class User extends Authenticatable
{
    use UuidModel;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'street_number',
        'street_name',
        'province_or_state',
        'postal_or_zip_code',
        'country_code',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'id',
        'created_at',
        'updated_at',
    ];


    public function getName()
    {
        if ($this->first_name && $this->last_name)
        {
            return "{$this->first_name} {$this->last_name}";
        }

        if ($this->first_name)
        {
            return $this->first_name;
        }

        return null;
    }

    public function getNameorUserName()
    {
        return $this->getName() ?: $this->username;
    }

    public function getFirstNameOrUsername()
    {
        return $this->first_name ?: $this->username;
    }


    /**
     *
     * Relationships
     *
     *
     */


    public function apps()
    {
        return $this->hasMany('Manticore\App', 'user_uuid', 'uuid');
    }









}
