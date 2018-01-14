<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PinPoint extends Model
{
    protected $table = 'pinpoint';

    protected $fillable = [
        'name','mobile', 'city', 'state', 'address'
    ];

}
