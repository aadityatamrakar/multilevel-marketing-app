<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'member';

    protected $fillable = [
        's_id','name', 'father_name', 'dob_d', 'dob_m', 'dob_y', 'mobile', 'paytm_no', 'address',
        'pincode', 'city', 'state', 'pancard', 'applied_pan', 'nominee_name',
        'nominee_relation', 'bank', 'account_no', 'ifsc', 'branch', 'password', 's_id', 'district',
        'id_proof', 'bank_proof', 'kyc_s'
    ];

    public function team()
    {
        return $this->hasMany('App\Member', 's_id', 'id');
    }

    public function sponsor()
    {
        return $this->hasOne('App\Member', 'id', 's_id');
    }

    public function reg_pin()
    {
        return $this->hasOne('App\Epin', 'reg_id', 'id');
    }

    public function pins()
    {
        return $this->hasMany('App\Epin', 'member_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany('App\Account', 'member_id', 'id');
    }

    public function pv()
    {
        return $this->hasOne('App\MemberPV', 'member_id', 'id');
    }
}
