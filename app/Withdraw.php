<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    protected $table = 'withdraw';

    protected $fillable = [
        'member_id', 'total', 'amount', 'chrg', 'remarks', 'done', 'paid'
    ];

    public function member()
    {
        return $this->hasOne('App\Member', 'id', 'member_id');
    }
}
