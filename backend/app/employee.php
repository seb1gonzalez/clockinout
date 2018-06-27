<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employee extends Model
{

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'classification', 'inorout', 'pin', 'email', 'phone_number'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}