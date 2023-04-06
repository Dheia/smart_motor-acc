<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Reception extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'receptions';

    protected $fillable = [
        'name','number', 'username', 'password','is_block'
    ];



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
