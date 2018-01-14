<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberPV extends Model
{
    protected $table = 'member_pv';

    protected $fillable = [
        'member_id', 'pv', 'members', 'activated', 'level', 'highest', 'all_act', 'club'
    ];
}
