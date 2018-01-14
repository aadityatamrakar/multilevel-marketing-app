<?php

namespace App\Http\Controllers;

use App\Account;
use App\Epin;
use App\Member;
use App\MemberPV;
use App\Withdraw;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    protected $member;
    public function __construct()
    {
        $this->member = Member::findOrFail($_SESSION['member_id']);
    }

    public function send_otp()
    {
        $otp = rand(10000, 99999);
        $this->sms($this->member->mobile, "Your OTP is ".$otp." for PlayCardsWell.");
        $_SESSION['otp'] = $otp;
        return 'sent';
    }
    public function dashboard()
    {
        $self_active = 0;
        $all_team = $this->member->pv['all_act'];

        foreach ($this->member->team as $m){
            if($m->reg_pin !== null){
                $self_active++;
            }
        }

        $member = $this->member;
        return view('member.dashboard', compact('member', 'self_active', 'all_team'));
    }

    public function account() { return view('member.account'); }
    public function account_withdraw()
    {
        $requested = Withdraw::where('member_id', $this->member->id)->where('done', 0)->sum('total');
        $available_funds = $this->acc_bal($this->member) - $requested;

        return view('member.withdraw', compact('available_funds'));
    }

    public function account_withdraw_post(Request $request)
    {
        $requested = Withdraw::where('member_id', $this->member->id)->where('done', 0)->sum('total');
        $available = $this->acc_bal($this->member) - $requested;
        $validator = Validator::make($request->all(), [
            "total"     => "required|numeric|max:$available|min:1",

        ]);
        if($validator->fails()) {
            return ['status' => "error", 'error' => $validator->errors()];
        }else{
            $chrg = $request->total*0.05;
            $amount= $request->total - $chrg;
            $withdraw = (new \App\Withdraw)->create([
                "member_id" => $this->member->id,
                "total" => $request->total,
                "chrg"  => $chrg,
                "amount"=> $amount,
            ]);
            return ['status'=>'done', 'withdraw'=>$withdraw];
        }
    }

    public function account_statement(Request $request)
    {
        if($request->has('from_date') && $request->has('to_date')){
            $accounts = Account::where([['member_id', '=', $this->member->id],
                ['created_at', '>=', Carbon::createFromFormat('d/m/Y', $request->from_date)],
                ['created_at', '<=', Carbon::createFromFormat('d/m/Y', $request->to_date)]])->where('display', 1)->get();
        }else{
            $accounts = $this->member->transactions->where('display', 1);
        }
        $data = [];
        $b = 0;
        foreach ($accounts as $t)
        {
            $d = Carbon::parse($t->created_at)->format('d/m/Y');
            if( isset($data[$d]) ){
                if( isset($data[$d][$t->type]) ){
                    $data[$d][$t->type] += $t->amount;
                }else{
                    $data[$d][$t->type] = $t->amount;
                }
                if($t->type == 'cr') $data[$d]['balance'] +=$t->amount;
                else $data[$d]['balance'] -=$t->amount;
            }else{
                $data[$d] = [$t->type => $t->amount, 'balance'=>($t->type=='cr')?$b+$t->amount:$b-$t->amount];
            }
            $b = $data[$d]['balance'];
        }

        return view('member.account_statement', compact('data', 'b'));
    }
    public function account_payout(Request $request)
    {
        if($request->has('date')){
            $accounts = Account::where('member_id', $this->member->id)->where(DB::raw('DATE_FORMAT(created_at, \'%d/%m/%Y\')'), $request->date)->where('display', 1)->get();
        }else{
            $accounts = Account::where([['member_id', $this->member->id],
                [DB::raw('DATE_FORMAT(created_at, \'%d/%m/%Y\')'), DB::raw('DATE_FORMAT(NOW(), \'%d/%m/%Y\')')]])->where('display', 1)->get();
        }

        return view('member.account_payout', compact('accounts'));
    }
    public function account_fundtransfer()
    {
        $available = $this->acc_bal($this->member);
        return view('member.account_fund', compact('available'));
    }

    public function account_fundtransfer_post(Request $request)
    {
        $otp = $_SESSION['otp'];
        $messages = [
            'size' => 'OTP Entered is invalid, Check again.',
        ];
        $available = $this->acc_bal($this->member);
        $validator = Validator::make($request->all(), [
            "member_id"  => "required|exists:member,id",
            "amount"     => "required|numeric|min:0|max:$available",
            "otp"        => "required|numeric|size:$otp"
        ], $messages);


        if($validator->fails()) {
            return ['status' => "error", 'error' => $validator->errors()];
        }else{
            if($request->member_id !== $this->member->id){
                Account::create([
                    'member_id'=>$this->member->id,
                    'title'=>"Funds Transferred to ID: ".$request->member_id,
                    'amount'=>$request->amount,
                    'type'=>'dr',
                    'display'=>1,
                    'total'=>$request->amount
                ]);

                Account::create([
                    'member_id'=>$request->member_id,
                    'title'=>"Funds received from ID: ".$this->member->id,
                    'amount'=>$request->amount,
                    'type'=>'cr',
                    'display'=>1,
                    'total'=>$request->amount
                ]);

                $this->sms($this->member->mobile, "You have transferred Rs. ".$request->amount." to ID: ".$request->member_id." was successful. PlayCardsWell.");
            }
            return ['status'=>'done'];
        }
    }

    public function direct_team() { return view('member.direct_team'); }
    public function self_team()
    {
        $members = [];
        $active = 0;
        $ids = [];
        foreach(Member::find($this->member->id)->team as $m) { $ids[] = $m->only(['id', 's_id', 'name']); }
        for($i=0; $i<count($ids); $i++){
            foreach(Member::find($ids[$i]['id'])->team as $m) { $ids[] = $m->only(['id', 's_id', 'name']); }
        }

        foreach ($ids as $id){
            $members[] = Member::find($id['id']);
        }

        return view('member.self_team', compact('members', 'active'));
    }
    public function all_team() { $active =0; return view('member.all_team', compact('active')); }

    public function addMembers($members, $id)
    {
        foreach(Member::find($id)->team as $m){
            $members[$m->id] = $m->only(['id', 's_id', 'name']);
        }
        return $members;
    }

    public function epins() { return view('member.epin'); }
    public function epin_generate() { $acc_bal = $this->acc_bal($this->member); return view('member.epin_generate', compact('acc_bal')); }
    public function epin_generate_post( Request $request )
    {
        $otp = $_SESSION['otp'];
        $messages = ['size' => 'OTP Entered is invalid, Check again.'];

        $validator = Validator::make($request->all(), [
            "package"   => "required",
            "epins"     => "required|numeric|min:0",
            "otp"       => "required|numeric|size:$otp"
        ], $messages);

        if($validator->fails()) {
            return ['status' => "error", 'error' => $validator->errors()];
        }else{
            $acc_bal = $this->acc_bal($this->member);
            $amount = ($request->package*$request->epins);
            if($acc_bal >= $amount) {
                $data = [
                    'value' => $request->get('package'),
                    'member_id' => $this->member->id,
                    'status'    => "NEW",
                    'gen_by'    => "member"
                ];
                $epins = $this->get_epins($request->epins);
                for($i=0; $i<count($epins); $i++){
                    $data['code'] = $epins[$i];
                    Epin::create($data);
                }
                Account::create(['member_id'=>$this->member->id, 'title'=>"EPIN Generate ".$request->epins." Nos, Package: ".$request->package, 'amount'=>$amount, 'type'=>'dr', 'total'=>$amount, 'display'=>1]);
                return ['status'=>'done'];
            }else{
                return ['status'=>'error', 'error'=>"insufficient balance."];
            }
        }
    }
    public function epin_topup() { return view('member.epin_topup'); }
    public function epin_transfer()
    {
        $data = $this->member->pins->where('status', 'NEW');
        $epins = [3000=>0, 4000=>0];
        foreach($data as $epin){
            $epins[$epin['value']] += 1;
        }
        return view('member.epin_transfer', compact('epins'));
    }

    public function epin_transfer_post( Request $request )
    {
        $data = $this->member->pins->where('status', 'NEW');
        $epins = [3000=>0, 4000=>0];
        foreach($data as $epin){
            $epins[$epin['value']] += 1;
        }

        $validator = Validator::make($request->all(), [
            "member_id"     => "required|exists:member,id",
            "pin"           => "required",
            "epins"         => "numeric|min:0|max:".$epins[$request->pin],
        ]);

        if($validator->fails()) {
            return ['status' => "error", 'error' => $validator->errors()];
        }else{
            $q3 = $request->epins;
            $data = $this->member->pins->where('status', 'NEW');
            $epins = [3000=>0, 4000=>0];
            foreach($data as $epin){
                if ($q3 > 0 && $epin->value == $request->pin){
                    $q3--;
                    Epin::where('code', $epin->code)->update(['member_id'=> $request->member_id]);
                }
            }
            return ['status'=>'done'];
        }
    }
    public function epin_topup_post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "reg_id"    => "required|exists:member,id",
            "epin"      => "required",
        ]);

        if($validator->fails()) {
            return ['status' => "error", 'error' => $validator->errors()];
        }else{
            $epin = Epin::where('code', $request->epin)->first();

            if($epin->status == "USED"){
                return ['status'=>"error", 'error'=>"PIN Already Used."];
            }

            $epin->reg_id = $request->reg_id;
            $epin->status = "USED";
            $epin->save();
            $sponsor = Member::find($request->reg_id)->sponsor;
            $amount = 300;
            $admin_chrg= $amount*0.1;
//            if($sponsor->pancard != ''){
//                $tds = $amount * 0.05;
//            }else {
//                $tds = $amount * 0.2;
//            }
            $tds = $amount * 0.05;
            $amount -= ($tds+$admin_chrg);
            if($sponsor->reg_pin !== null)
            {
                Account::create([
                    'member_id'=>$sponsor->id,
                    'title'=>'ID Topup, ID: PCW'.$request->reg_id,
                    'amount'=>$amount,
                    'type'=>'cr',
                    'display'=>0,
                    'total'=>300,
                    'admin_chrg'=>$admin_chrg,
                    'tds'=>$tds
                ]);

            }
            $update = $sponsor;
            do{
                $update->pv->activated += 1;
                $update->pv->save();
                $update = $update->sponsor;
            }while ($update !== null);

            DB::update('update member_pv set all_act=all_act+1 where member_id < ?', [$request->reg_id]);

            return ['status'=>'done'];
        }
    }

    public function setting() { return view('member.setting'); }
    public function change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "password"      => "required",
            "re_password"   => "required|same:password",
        ]);

        if($validator->fails()){
            return redirect()->route('login', ['info'=>"Login details are required.", 'type'=>"danger"]);
        }

        $this->member->password = $request->password;
        $this->member->save();
        return ['status'=>'done'];
    }

    public function profile() { $member=$this->member; return view('member.profile', compact('member')); }
    public function post_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "paytm_no"      => "size:10",
            "ifsc"          => "size:11",
            "account_no"    => "numeric",
        ]);
        if ($validator->fails()) {
            return ['status'=>"error", "error"=>$validator->errors()];
        }else{
            Member::where('id', $this->member->id)->update($request->all());
            if($this->member->pancard !== ''){
                $this->member->applied_pan = "";
                $this->member->save();
            }
            return ['status'=>"done"];
        }

    }

    public function kyc() { $member=$this->member; return view('member.kyc', compact('member')); }

    public function post_kyc(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "address_proof_front"   => "required",
            "address_proof_back"    => "required",
            "pancard"               => "required",
            "id_proof"              => "required",
            "bank_proof"            => "required",
            "cheque"                => "required",
        ]);

        if ($validator->fails()) {
            return ['status'=>"error", "error"=>"All fields are required"];
        }else{
            $id_proof_txt = $request->id_proof;
            $bank_proof_txt = $request->bank_proof;
            $this->member->id_proof = $id_proof_txt;
            $this->member->bank_proof = $bank_proof_txt;
            $this->member->kyc_s = 'uploaded';
            $this->member->save();

            $address_proof_front = base64_decode(substr($request->address_proof_front, strpos($request->address_proof_front, 'base64')+6));
            $address_proof_back  = base64_decode(substr($request->address_proof_back, strpos($request->address_proof_back, 'base64')+6));
            $id_proof = base64_decode(substr($request->pancard, strpos($request->pancard, 'base64')+6));
            $cheque = base64_decode(substr($request->cheque, strpos($request->cheque, 'base64')+6));

            $im_ap_front = imagecreatefromstring($address_proof_front);
            $im_ap_back = imagecreatefromstring($address_proof_back);
            $im_ip = imagecreatefromstring($id_proof);
            $im_c = imagecreatefromstring($cheque);
            imagejpeg($im_ap_front, str_replace(['app', 'Http', 'Controllers'], ['public', 'uploads', 'member'], __DIR__).'/apf_'.$this->member->id.'.jpg', 90);
            imagejpeg($im_ap_back, str_replace(['app', 'Http', 'Controllers'], ['public', 'uploads', 'member'], __DIR__).'/apb_'.$this->member->id.'.jpg', 90);
            imagejpeg($im_ip, str_replace(['app', 'Http', 'Controllers'], ['public', 'uploads', 'member'], __DIR__).'/ip_'.$this->member->id.'.jpg', 90);
            imagejpeg($im_c, str_replace(['app', 'Http', 'Controllers'], ['public', 'uploads', 'member'], __DIR__).'/c_'.$this->member->id.'.jpg', 90);
            imagedestroy($im_ap_front);
            imagedestroy($im_ap_back);
            imagedestroy($im_ip);
            imagedestroy($im_c);

            return ['status'=>"done"];
        }
    }

    public function profile_photo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "photo" => "required",
        ]);

        if ($validator->fails()) {
            return ['status'=>"error", "error"=>"All fields are required"];
        }else{
            $photo = base64_decode(substr($request->photo, strpos($request->photo, 'base64')+6));
            $im_ap = imagecreatefromstring($photo);
            imagejpeg($im_ap, str_replace(['app', 'Http', 'Controllers'], ['public', 'uploads', 'member'], __DIR__).'/pp_'.$this->member->id.'.jpg', 90);
            imagedestroy($im_ap);
            return ['status'=>"done"];
        }
    }


    public function test()
    {
        echo "<pre>";
        $epins = Epin::where('reg_id', '!=', null)->get();
        foreach ($epins as $e){
            echo $e->reg_id. " SPONSOR . ";
            $sponsor = Member::find($e->reg_id)->sponsor;
            if($sponsor == null) continue;
            echo $sponsor->id;
            $amount = 300;
            $admin_chrg= $amount*0.1;
//            if($sponsor->pancard != ''){
//                $tds = $amount * 0.05;
//            }else {
//                $tds = $amount * 0.2;
//            }
            $amount -= ($admin_chrg);
            echo " AMOUNT: ".$amount;
            $account = new Account();
            $account->create([
                'member_id'=>$sponsor->id,
                'title'=>'ID Topup, ID: PCW'.$e->reg_id,
                'amount'=>$amount,
                'type'=>'cr',
                'display'=>0,
                'total'=>300,
                'admin_chrg'=>$admin_chrg,
                'tds'=>0
            ]);
            echo " ACC ID: ".$account->id."<br>";
        }
    }
    public function logout()
    {
        session_destroy();
        return redirect()->route('home');
    }
}
