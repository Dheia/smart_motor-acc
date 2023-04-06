<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Section extends Authenticatable
{

    protected $table = "sections";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'user_id'
    ];
}
