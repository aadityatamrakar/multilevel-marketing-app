<?php

namespace App\Http\Controllers;

use App\Epin;
use App\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{

    public static function level_name($i)
    {
        $level_info = [
            ["name"=>"Manager", 'downline'=>0, 'pv'=>0, 'income'=>0],
            ["name"=>"Area Manager", 'downline'=>0, 'pv'=>50000, 'income'=>500],
            ["name"=>"Junior Manager", 'downline'=>1, 'pv'=>100000, 'income'=>1000],
            ["name"=>"Team Manager", 'downline'=>2, 'pv'=>250000, 'income'=>2500],
            ["name"=>"Life Manager", 'downline'=>3, 'pv'=>500000, 'income'=>5000],
            ["name"=>"National Manager", 'downline'=>4, 'pv'=>1000000, 'income'=>10000],
            ["name"=>"International Manager", 'downline'=>5, 'pv'=>2500000, 'income'=>0],
            ["name"=>"World Manager", 'downline'=>6, 'pv'=>5000000, 'income'=>0],
            ["name"=>"Global Manager", 'downline'=>7, 'pv'=>10000000, 'income'=>0],
            ["name"=>"Double Manager", 'downline'=>8, 'pv'=>25000000, 'income'=>0],
            ["name"=>"Triple Manager", 'downline'=>9, 'pv'=>50000000, 'income'=>0],
            ["name"=>"Crown Manager", 'downline'=>10, 'pv'=>100000000, 'income'=>0],
            ["name"=>"Royal Manager", 'downline'=>11, 'pv'=>250000000, 'income'=>0],
        ];

        return $level_info[$i]['name'];
    }

    public static function level($i, $v)
    {

        $level_info = [
            ["name"=>"Area Manager", 'downline'=>0, 'pv'=>50000, 'income'=>500],
            ["name"=>"Junior Manager", 'downline'=>1, 'pv'=>100000, 'income'=>1000],
            ["name"=>"Team Manager", 'downline'=>2, 'pv'=>250000, 'income'=>2500],
            ["name"=>"Life Manager", 'downline'=>3, 'pv'=>500000, 'income'=>5000],
            ["name"=>"National Manager", 'downline'=>4, 'pv'=>1000000, 'income'=>10000],
            ["name"=>"International Manager", 'downline'=>5, 'pv'=>2500000, 'income'=>0], // 5
            ["name"=>"World Manager", 'downline'=>6, 'pv'=>5000000, 'income'=>0],
            ["name"=>"Global Manager", 'downline'=>7, 'pv'=>10000000, 'income'=>0],
            ["name"=>"Double Manager", 'downline'=>8, 'pv'=>25000000, 'income'=>0],
            ["name"=>"Triple Manager", 'downline'=>9, 'pv'=>50000000, 'income'=>0],
            ["name"=>"Crown Manager", 'downline'=>10, 'pv'=>100000000, 'income'=>0],
            ["name"=>"Royal Manager", 'downline'=>11, 'pv'=>250000000, 'income'=>0],
        ];

        return $level_info[$i][$v];
    }

    public static function club($i, $v)
    {
        $club = [
            ["name"=>"No Club", 'hpv'=>0, 'opv'=> 0, 'income'=>0],
            ["name"=>"Silver", 'hpv'=>50000, 'opv'=> 50000, 'income'=>100],
            ["name"=>"Gold", 'hpv'=>100000, 'opv'=> 100000, 'income'=>100],
            ["name"=>"Platinum", 'hpv'=>250000, 'opv'=> 250000, 'income'=>50],
            ["name"=>"Emerald", 'hpv'=>500000, 'opv'=> 500000, 'income'=>50],
            ["name"=>"Diamond", 'hpv'=>1000000, 'opv'=> 1000000, 'income'=>25],
            ["name"=>"Double Diamond", 'hpv'=>2500000, 'opv'=> 2500000, 'income'=>25],
            ["name"=>"Triple Diamond", 'hpv'=>5000000, 'opv'=> 5000000, 'income'=>25],
            ["name"=>"Ambassador", 'hpv'=>10000000, 'opv'=> 10000000, 'income'=>25],
        ];

        return $club[$i][$v];
    }

    public function generate_epin($length = 10)
    {
        $characters = '23456789ABCDEFGHJKLMNPQRTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function get_epins($count)
    {
        $epins = [];
        do{
            $epin = $this->generate_epin();
            if( Epin::where('code', $epin)->first() === null ){
                $epins[] = $epin;
            }
        }while($count > count($epins));

        return $epins;
    }

    public function acc_bal($member)
    {
        $transactions_cr = $member->transactions->where('display', 1)->where('type', 'cr')->sum('amount');
        $transactions_dr = $member->transactions->where('display', 1)->where('type', 'dr')->sum('amount');
        $balance = $transactions_cr - $transactions_dr;

        return $balance;
    }

    public function member_reg(Request $request)
    {
        $member = Member::findOrFail($request->id);
        $data = ['n'=>$member->name, 'd'=>Carbon::parse($member->created_at)->diffInDays(), 'r'=>$member->created_at, 'p'=>$member->reg_pin];
        if($member->reg_pin == null){
            if($data['d'] > 7){
                if( ($pin = Epin::where([['member_id', '=', $_SESSION['member_id']], ['value','=', 4000], ['reg_id','=', null]])->first()) !== null){
                    $data['a'] = $pin->code;
                }
            }else{
                if( ($pin = Epin::where([['member_id', '=', $_SESSION['member_id']], ['value','=', 3000],['reg_id','=', null]])->first()) !== null){
                    $data['a'] = $pin->code;
                }
            }
        }
        $data['acc'] = $this->acc_bal($member);
        return $data;
    }

    public static function sms($mobile, $msg)
    {
        $mobile = urlencode("91".$mobile);
        $msg = urlencode($msg);
        $url = "http://sms.hostingfever.in/sendSMS?username=pcw&message=$msg&sendername=PLAYCW&smstype=TRANS&numbers=$mobile&apikey=68a0091e-083f-4d97-9231-649e2546533c";
        return file_get_contents($url);
    }
}
