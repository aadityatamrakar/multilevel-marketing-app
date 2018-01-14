<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Epin extends Model
{
    protected $table = 'epin';

    protected $fillable = [
        'member_id','reg_id', 'code', 'status', 'value', 'gen_by'
    ];

}
