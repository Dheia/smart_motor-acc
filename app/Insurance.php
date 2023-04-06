<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Insurance extends Authenticatable
{

    protected $table = "insurances";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_name', 'contact_no','email','subrogation','signature_position','TRN','address'
    ];
}
