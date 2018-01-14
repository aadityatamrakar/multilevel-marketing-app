<?php

namespace App\Http\Controllers;

use App\Member;
use App\MemberPV;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Validator;
use \Illuminate\Http\Request;

class WebsiteController extends Controller
{

    public function index() { return view('home'); }
    public function contact() { return view('contact'); }
    public function business() { return view('business'); }
    public function success_reg() { return view('success'); }
    public function product() { return view('product'); }
    public function about_us() { return view('about'); }

    public function login()
    {
        if(isset($_SESSION['role']) && $_SESSION['role'] == 'member') {
            return redirect()->route('member.dashboard');
        }else if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
            return redirect()->route('admin.dashboard');
        }
        $body_class = 'login-page';
        return view('login', compact('body_class'));
    }

    public function post_login(Request $request){

        $validator = Validator::make($request->all(), [
            "username"  => "required",
            "password"  => "required",
        ]);

        if($validator->fails()){
            return redirect()->route('login', ['info'=>"Login details are required.", 'type'=>"danger"]);
        }

        if(strtolower(substr($request->username, 0, 3)) == 'pcw'){
            $member = Member::where([['id', substr($request->username, 3)], ['password', $request->password]])->first();
            if($member !== null){
                $_SESSION['role'] = 'member';
                $_SESSION['member_id'] = $member->id;
                $_SESSION['member_name'] = $member->name;
                setcookie('username', $request->username);
                return redirect()->route('member.dashboard', ['info'=>"Login Success!", 'type'=>"success"]);
            }else{
                return redirect()->route('login', ['info'=>"Login Failed!", 'type'=>"danger"]);
            }
        }elseif($request->username == 'admin' && $request->password == Member::find(10001)->password){
            $_SESSION['role'] = 'admin';
            return redirect()->route('admin.dashboard', ['info'=>"Login Success!", 'type'=>"success"]);
        }else{
            return redirect()->route('login', ['info'=>"Login Failed!", 'type'=>"danger"]);
        }
    }

    public function register()
    {
        $body_class = 'login-page';
        return view('register', compact('body_class'));
    }

    public function post_register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "s_id"          => "required|exists:epin,reg_id",
            "name"          => "required",
            "mobile"        => "required|size:10",
            "paytm_no"      => "size:10",
            "pancard"       => "required_unless:applied_pan,Yes|size:10",
            "ifsc"          => "size:11",
            "account_no"    => "numeric",
        ]);

        if ($validator->fails()) {
            return ['status'=>"error", "error"=>$validator->errors()];
        }else{
            $member = Member::create($request->all());
            $member->password = rand(1000, 9999);
            $member->save();
            MemberPV::updateOrCreate(['member_id'=>$member->id], ["activated"=>0, "members"=>0, 'pv'=>0, 'highest'=>0, 'level'=>0]);
            $this->sms($request->mobile, "Thanks for Registering in PlayCardsWell. Your ID: PCW".$member->id.", Password: ".$member->password." , For Details Visit www.playcardswell.com");
            return ['status'=>"success", 'id'=>$member->id, 'name'=>$member->name, 'mobile'=>$member->mobile, 'password'=>$member->password];
        }
    }

    public function fpassword()
    {
        return view('fpassword');
    }

    public function post_fpassword(Request $request)
    {
        $member = Member::find(str_replace('pcw', '', strtolower($request->username)));

        if($member !== null && $member->mobile == $request->mobile){
            $password = rand(1000, 9999);
            $member->password = $password;
            $member->save();
            $this->sms($request->mobile, "Your new login password of ID: PCW".$member->id." is Password: ".$member->password." , For Details Visit www.playcardswell.com");
            return redirect()->route('login', [
                'info'=>"New Password Sent to Registered Mobile.",
                'type'=>'success'
            ]);
        }else{
            if($member === null){
                return redirect()->route('fpassword', [
                    'info'=>"Invalid Member username.",
                    'type'=>'danger'
                ]);
            }else{
                return redirect()->route('fpassword', [
                    'info'=>"Member registered mobile no. is incorrect.",
                    'type'=>'danger'
                ]);
            }
        }
    }

    public function member_name(Request $request)
    {
        $member = Member::findOrFail($request->id);
        return $member->name.(($member->reg_pin==null)?" NOT ACTIVE":"");
    }

}
