<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'account';

    protected $fillable = [
        'member_id','title', 'amount', 'type', 'display', 'admin_chrg', 'tds', 'total'
    ];

    public function member()
    {
        return $this->hasOne('App\Member', 'id', 'member_id');
    }
}
