<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name', 'user', 'password'
    ];
}
