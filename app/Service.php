<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Service extends Authenticatable
{

    protected $table = "services";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'section_id'
    ];
}
