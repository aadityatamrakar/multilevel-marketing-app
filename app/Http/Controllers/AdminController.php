<?php

namespace App\Http\Controllers;

use App\Account;
use App\Epin;
use App\Member;
use App\MemberPV;
use App\News;
use App\PinPoint;
use App\Withdraw;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use \Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function dashboard() { return view('admin.dashboard'); }

    public function epin()
    {
        return view('admin.epin');
    }
    public function post_epin(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "member_id"  => "required|exists:member,id",
            "quantity"  => "required",
            "value"  => "required",
        ]);

        if($validator->fails()){
            return ['status'=>"error", 'error'=>$validator->errors()];
        }else{

            $data = [
                'value' => $request->get('value'),
                'member_id' => $request->get('member_id'),
                'status'    => "NEW",
            ];

            $epins = $this->get_epins($request->quantity);

            for($i=0; $i<count($epins); $i++){
                $data['code'] = $epins[$i];
                $data['gen_by'] = 'admin';
                Epin::create($data);
            }
            return ['status'=>'done'];
        }
    }

    public function members()
    {
        $sql = 'SELECT member.id, member.s_id, member.name, member.created_at, member_pv.all_act, epin.updated_at from member JOIN member_pv ON member.id= member_pv.member_id LEFT JOIN epin ON epin.reg_id=member.id';
        $members = DB::select($sql);
        return view('admin.member', compact('members'));
    }
    public function member_delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id"  => "required",
        ]);

        if($validator->fails()){
            return ['status'=>"error", 'error'=>$validator->errors()];
        }else{
            $member = Member::findOrFail($request->id);
            if( count($member->team) > 0 ){
                return ['status'=>'error', 'error'=>"Member has downline, Cannot Delete."];
            }else{
                MemberPV::where('member_id', $member->id)->first()->delete();
                $member->delete();
                return ['status'=>'done'];
            }
        }
    }
    public function member_view($id)
    {
        $member = Member::findOrFail($id);
        $kyc = [];
        $kyc['apf'] = file_exists(str_replace(['app', 'Http', 'Controllers'], ['public', 'uploads', 'member'], __DIR__).'/apf_'.$member->id.'.jpg');
        $kyc['apb'] = file_exists(str_replace(['app', 'Http', 'Controllers'], ['public', 'uploads', 'member'], __DIR__).'/apb_'.$member->id.'.jpg');
        $kyc['ip'] = file_exists(str_replace(['app', 'Http', 'Controllers'], ['public', 'uploads', 'member'], __DIR__).'/ip_'.$member->id.'.jpg');
        $kyc['c'] = file_exists(str_replace(['app', 'Http', 'Controllers'], ['public', 'uploads', 'member'], __DIR__).'/c_'.$member->id.'.jpg');

        $kyc['id'] = $member->id_proof;
        $kyc['bank'] = $member->bank_proof;

        $_SESSION['member_id'] = $id;

        return view('admin.member_view', compact('member', 'kyc'));
    }

    public function kyc_update(Request $request)
    {
        $member = Member::findOrFail($request->id);
        if($request->do == 'approve')
            $member->kyc = 1;
        else
            $member->kyc = 0;
        $member->save();
        return ['status'=>'done'];
    }
    public function member_edit($id)
    {
        $member = Member::findOrFail($id);
        return view('admin.member_edit', compact('member'));
    }
    public function post_member_edit($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name"          => "required",
            "mobile"        => "required|size:10",
            "paytm_no"      => "size:10",
            "pancard"       => "required_unless:applied_pan,Yes|size:10",
            "ifsc"          => "size:11",
            "account_no"    => "numeric",
            "password"      => "required"
        ]);

        if ($validator->fails()) {
            return ['status'=>"error", "error"=>$validator->errors()];
        }else{
            $member = Member::findOrFail($id)->update($request->all());
            return ['status'=>"success"];
        }
    }

    public function member_pv($id = null)
    {
        if($id == null){
            $members = Member::select('id', 's_id', 'name')->orderBy('id', 'desc')->get();
        }else {
            $members = Member::select('id', 's_id', 'name')->where('id', $id)->orderBy('id', 'desc')->get();
        }

        $data = [];

        foreach ($members as $m){

            $d = null;

            $smembers = Member::select('id', 'name')->where('s_id', $m->id)->orderBy('id', 'desc')->get();
            if( count($smembers) > 0)
            {
                $data[$m->id] = ["activated"=>0, "members"=>0, 'pv'=>0];
                foreach ($smembers as $m2){
                    if($m2->reg_pin!==null) {
                        $data[$m->id]['members'] += 1;
                        $data[$m->id]['activated'] += 1;
                    }else{
                        $data[$m->id]['members'] += 1;
                    }

                    if(isset($data[$m2->id])){
                        $data[$m->id]['activated'] += $data[$m2->id]['activated'];
                        $data[$m->id]['members'] += $data[$m2->id]['members'];
                        $data[$m->id]['pv'] += $data[$m2->id]['pv'];
                    }
                }
            }else{
                $data[$m->id] = $this->set_d($m);
                // echo "M1: ". $m->id. ' - '. $data[$m->id]['members']. "<br>";
            }
            MemberPV::updateOrCreate(['member_id'=>$m->id], $data[$m->id]);
        }

        if(isset($_GET['print']))
            echo "<pre>". print_r($data, true). "</pre>";
        else
            echo "Updated!";
    }

    public function total_act()
    {
        $members = Member::select('id', 's_id', 'name')->orderBy('id', 'desc')->get();
        $act = 0;
        foreach($members as $m){
            if($m->reg_pin !== null){
                $m->pv->all_act = $act;
                $m->pv->save();
                $act++;
            }else{
                MemberPV::updateOrCreate(['member_id'=>$m->id], ["all_act"=>$act]);
            }
        }
    }

    public function daily_closing()
    {
        // $this->member_pv();
        // $this->total_act();
        Account::where('display', 0)->update(['display'=>1]);

        return view('admin.daily');
    }
    public function old_member_level()
    {
        $members = Member::orderBy('id', 'desc')->get();
        $data = [];
        $act = 0;

        foreach($members as $m){
            if($m->reg_pin !== null) {
                $m->pv->all_act = $act;
                $m->pv->save();
                $act++;

                $level = 0;
                $d = null;
                $team_count = 0;
                foreach ($m->team as $t) {
                    if ($t->reg_pin === null) continue;
                    $team_count++;
                    // echo "M ID: " . $m->id . " Compare " . $t->id . "<br>";
                    if ($d !== null) {
                        // echo "Comparing " . $d->pv->level . " > " . $t->pv->level . "<br>";
                        if ($d->pv->level < $t->pv->level || ($d->pv->level == $t->pv->level && $d->pv->total_act < $t->pv->total_act)) {
                            $d = $t;
                        }
                    } else if ($d === null) $d = $t;

                    // echo "M ID: " . $m->id . " Set " . $d->id . "<br>";
                }

                if ($d !== null && $team_count > $m->pv->level) {
                    $m->pv->highest = $d->id;
                    // echo "M ID: " . $m->id . " has Direct Referral.<br>";
                    // echo "M ID: " . $m->id . " will run from " . ($d->pv->level + 1) . " to " . ($d->pv->level) . "<br>";
                    for ($i = ($d->pv->level); $i >= 0; $i--) {
                        // echo ($m->pv->all_act * 3000) . " > " . Controller::level($i, 'pv') . "<br>";
                        if (($m->pv->all_act * 3000) > Controller::level($i, 'pv')) {
                            $level = $i + 1;
                            // echo "M ID: " . $m->id . " has Level: $level.<br>";
                            break;
                        }
                    }
                }


                if ($m->pv->level < $level && $level > 0) {
                    $amount = Controller::level($level - 1, 'income');
                    $admin_chrg = $amount * 0.1;
                    if ($m->pancard == '') {
                        $tds = $amount * 0.2;
                    } else {
                        $tds = $amount * 0.05;
                    }
                    $amount -= ($tds + $admin_chrg);
                    Account::create([
                        'member_id' => $m->id,
                        'title' => "Level Achievement Payment",
                        'amount' => $amount,
                        'type' => 'cr',
                        'display' => 1,
                        'admin_chrg' => $admin_chrg,
                        'tds' => $tds,
                        'total' => ($amount + $admin_chrg + $tds)
                    ]);
                }
                if($level > 0){
                    $amount = Controller::level($level - 1, 'income');
                    $admin_chrg = $amount * 0.1;
                    // echo "ID: ".$m->id." PANCARD : ";
                    var_dump($m->pancard);
                    // echo "<br>";
                    if ($m->pancard == '') {
                        $tds = $amount * 0.2;
                    } else {
                        $tds = $amount * 0.05;
                    }
                    $amount -= ($tds + $admin_chrg);
                    // echo "Amout: ".$amount." TDS: ".$tds. " ADMIN: ".$admin_chrg."<br>";
                }

                $m->pv->level = $level;
                $m->pv->save();
            }
        }

        if(isset($_GET['print']))
            echo "<pre>". print_r($data, true). "</pre>";
        else
            echo "Updated!";
    }

    public function smsg($d, $m)
    {
        if($d) echo $m. "<br>";
    }

    public function member_level()
    {
        $members = DB::select('select member.id,member.name,member.pancard, member_pv.all_act, member_pv.level, member_pv.highest from member join member_pv on member.id = member_pv.member_id inner join epin on member.id = epin.reg_id order by member.id desc');
        $direct  = 0;
        $data = [];
        $debug = false;

        foreach( $members as $m ){
            $this->smsg($debug, $m->id . " starting calculation for next level ". ($m->level+1));
            $team = DB::select('select member.id, member.name, member_pv.level from member join member_pv on member.id = member_pv.member_id inner join epin on member.id = epin.reg_id where member.s_id=? ORDER BY `member_pv`.`level` DESC, `member_pv`.`all_act`  DESC', [$m->id]);
            $m->team = $team;
            $this->smsg($debug, $m->id . " team count ".count($team));
            $direct = count($team) - $m->level;
            if($direct > 0){ // direct downline
                $this->smsg($debug, $m->id . " has direct for next level.");
                if($m->team[0]->level >= $m->level){ // direct highest level
                    $this->smsg($debug, $m->id . " direct highest is in same level ". $m->level);
                    $this->smsg($debug, $m->id . " has pv ".($m->all_act * 3000)." required pv for next level is ". Controller::level($m->level, 'pv'));
                    if( ($m->all_act * 3000) >= Controller::level($m->level, 'pv')){ // total pv level level wise
                        $this->smsg($debug, $m->id . " has passed all checks, next level - ".($m->level+1));

                        $amount = Controller::level( $m->level, 'income');
                        $admin_chrg = $amount * 0.1;
//                        if ($m->pancard == '') {
//                            $tds = $amount * 0.2;
//                        } else {
//                            $tds = $amount * 0.05;
//                        }
                        $tds = $amount * 0.05;
                        $amount -= ($tds + $admin_chrg);
                        $this->smsg($debug, $m->id . " Amount: ".$amount." TDS: ".$tds. " ADMIN: ".$admin_chrg);
                        $m->account = ["amount"=>$amount, 'tds'=>$tds, 'admin'=>$admin_chrg];
                        $m->level += 1;
                        $m->highest = $m->team[0]->id;
                        $data[] = $m;
                        Account::create([
                            'member_id' => $m->id,
                            'title' => "Level Achievement Payment",
                            'amount' => $amount,
                            'type' => 'cr',
                            'display' => 1,
                            'admin_chrg' => $admin_chrg,
                            'tds' => $tds,
                            'total' => ($amount + $admin_chrg + $tds)
                        ]);
                        MemberPV::where('member_id', $m->id)->update(['level' => $m->level, 'highest' => $m->team[0]->id]);
                    }
                }
            }
        }

        return view('admin.weekly', compact('data'));
    }

    public function club_pv()
    {
        $members = DB::select('select member.id,member.name, member_pv.all_act, member_pv.level, member_pv.highest, (SELECT COUNT(*) from member as t1 WHERE t1.s_id=member.id ) as `downline`, member_pv.club from member join member_pv on member.id = member_pv.member_id inner join epin on member.id = epin.reg_id order by member.id desc');
        $direct  = 0;
        $data = [];
        $debug = false;

        foreach( $members as $m ){

            $id = "PCW".$m->id;
            $m->team = DB::select('select member.id, member.name, member_pv.level, member_pv.activated, (SELECT COUNT(*) from member as t1 WHERE t1.s_id=member.id ) as `downline` from member join member_pv on member.id = member_pv.member_id inner join epin on member.id = epin.reg_id where member.s_id=? ORDER BY `member_pv`.`level` DESC, `member_pv`.`all_act` DESC, `downline` DESC', [$m->id]);

            $count = count($m->team);
            $direct = count($m->team) - $m->level;
            $h = count($m->team ) > 0 ? $m->team[0]->activated+1 : 0;
            for($i=1, $o=0; $i<count($m->team); $i++) { $o+= $m->team[$i]->activated+1; }
            $h *= 3000;
            $o *= 3000;

            if(count($m->team ) > 0)
                $h = [$h , 'PCW'.$m->team[0]->id];
            else
                $h = [$h];
            $o = $o;

            $data[] = [ 'id' => $id, 'c' =>$count, 'h'=>$h, 'o'=>$o ];
        }

        return view('admin.club_pv', compact('data'));
        //return view('admin.weekly', compact('data'));
    }

    public function new_member_level()
    {
        $members = DB::select('select member.id,member.name, member_pv.all_act, member_pv.level, member_pv.highest, (SELECT COUNT(*) from member as t1 WHERE t1.s_id=member.id ) as `downline`, member_pv.club from member join member_pv on member.id = member_pv.member_id inner join epin on member.id = epin.reg_id order by member.id desc');
        $direct  = 0;
        $data = [];
        $debug = false;

        foreach( $members as $m ){
            $this->smsg($debug, $m->id . " starting calculation for next level ". ($m->level+1));
            $m->team = DB::select('select member.id, member.name, member_pv.level, member_pv.activated, (SELECT COUNT(*) from member as t1 WHERE t1.s_id=member.id ) as `downline` from member join member_pv on member.id = member_pv.member_id inner join epin on member.id = epin.reg_id where member.s_id=? ORDER BY `member_pv`.`level` DESC, `member_pv`.`all_act` DESC, `downline` DESC', [$m->id]);
            $this->smsg($debug, $m->id . " team count ".count($m->team));
            $direct = count($m->team) - $m->level;
            if($direct > 0){ // direct downline
                $this->smsg($debug, $m->id . " has direct for next level.");
                if( ($m->all_act * 3000) >= Controller::level($m->level, 'pv')){ // total pv level wise
                    if($m->level > 3){
                        $h = count($m->team ) > 0 ? $m->team[0]->activated+1 : 0;
                        for($i=1, $o=0; $i<count($m->team); $i++) {
                            if($h < ($m->team[$i]->activated+1) ) {
                                $h = $m->team[$i]->activated+1;
                                $o += $m->team[0]->activated;
                            }
                            else $o+= $m->team[$i]->activated+1;
                        }

                        $h *= 3000; $o *= 3000;

                        if($h >= Controller::club($m->club+1, 'hpv') && $o >= Controller::club($m->club+1, 'opv')){
                            $this->smsg($debug, $m->id . " highest having pv ". $h ." required pv for next level is ". Controller::club($m->club+1, 'hpv'));
                            $this->smsg($debug, $m->id . " has other total pv ".($o)." required pv for next level is ". Controller::club($m->club+1, 'opv'));

                            $amount = Controller::level( $m->level, 'income');
                            $admin_chrg = $amount * 0.1;
                            $tds = $amount * 0.05;
                            $amount -= ($tds + $admin_chrg);
                            $this->smsg($debug, $m->id . " Amount: ".$amount." TDS: ".$tds. " ADMIN: ".$admin_chrg);
                            $m->account = ["amount"=>$amount, 'tds'=>$tds, 'admin'=>$admin_chrg];
                            $m->level += 1;
                            $m->club += 1;
                            $data[] = $m;
//                            Account::create([
//                                'member_id' => $m->id,
//                                'title' => "Level Achievement Payment",
//                                'amount' => $amount,
//                                'type' => 'cr',
//                                'display' => 1,
//                                'admin_chrg' => $admin_chrg,
//                                'tds' => $tds,
//                                'total' => ($amount + $admin_chrg + $tds)
//                            ]);
                            MemberPV::where('member_id', $m->id)->update(['level' => $m->level, 'club' => $m->club, 'highest' => $m->team[0]->id]);
                        }
                    }else{
                        continue;

                        if($m->team[0]->level >= $m->level){ // direct highest level
                            $this->smsg($debug, $m->id . " direct highest is in same level ". $m->level);
                            $this->smsg($debug, $m->id . " has pv ".($m->all_act * 3000)." required pv for next level is ". Controller::level($m->level, 'pv'));

                            $this->smsg($debug, $m->id . " has passed all checks, next level - ".($m->level+1));
                            $amount = Controller::level( $m->level, 'income');
                            $admin_chrg = $amount * 0.1;
                            $tds = $amount * 0.05;
                            $amount -= ($tds + $admin_chrg);
                            $this->smsg($debug, $m->id . " Amount: ".$amount." TDS: ".$tds. " ADMIN: ".$admin_chrg);
                            $m->account = ["amount"=>$amount, 'tds'=>$tds, 'admin'=>$admin_chrg];
                            $m->level += 1;
                            $m->highest = $m->team[0]->id;
                            $data[] = $m;
                            Account::create([
                                'member_id' => $m->id,
                                'title' => "Level Achievement Payment",
                                'amount' => $amount,
                                'type' => 'cr',
                                'display' => 1,
                                'admin_chrg' => $admin_chrg,
                                'tds' => $tds,
                                'total' => ($amount + $admin_chrg + $tds)
                            ]);
                            MemberPV::where('member_id', $m->id)->update(['level' => $m->level, 'highest' => $m->team[0]->id]);
                        }
                    }
                }
            }
        }


        return view('admin.weekly', compact('data'));
    }

    public function set_d($m2)
    {
        $tmp = $this->get_all_mem($m2->id);
        $data[$m2->id] = $tmp['data'];
        $data[$m2->id]['m'] = count($tmp['data']);
        $data[$m2->id]['a'] = $tmp['a'];
        $h = 0;
        foreach($tmp['data'] as $s){
            if($s['a'] > $h) $h = $s;
        }

        return ['activated'=>$tmp['a'], 'members'=>$data[$m2->id]['m'], 'pv'=>($tmp['a']*3000), 'highest'=>$h['id']];

    }
    public function get_all_mem($id)
    {
        $members = Member::select('id', 'name')->where('s_id', $id)->orderBy('id', 'desc')->get();
        $data = [];
        $active = 0;
        foreach ($members as $m){ if($m->reg_pin!==null) $active++; array_push($data, ["id"=>$m->id, 'a'=>($m->reg_pin!==null)?true:false]); }

        for ($i=0; $i<count($data); $i++){
            $members = Member::select('id', 'name')->where('s_id', $data[$i]['id'])->orderBy('id', 'desc')->get();
            foreach ($members as $m){ if($m->reg_pin!==null) $active++; array_push($data, ["id"=>$m->id, "a"=>($m->reg_pin!==null)?true:false]); }
        }

        return ['data'=>$data, 'a'=>$active];
    }

    public function payment()
    {
        $wallet = DB::select("SELECT DISTINCT account.member_id, member.name, sum(case when account.type = 'cr' THEN account.amount END) cr, sum(case when account.type = 'dr' THEN account.amount END) dr FROM `account` join member on member.id = account.member_id WHERE account.display=1 GROUP BY member_id");
        return view('admin.payment', compact('wallet'));
    }

    public function withdraw()
    {
        return view('admin.withdraw');
    }

    public function post_withdraw(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "pid"           => "required|numeric|exists:withdraw,id"
        ]);

        if ($validator->fails()) {
            return ['status'=>"error", "error"=>$validator->errors()];
        }else{
            $withdraw = Withdraw::find($request->pid);
            $member = $withdraw->member;
            $balance = $this->acc_bal($member);

            if($withdraw->total > $balance){
                return ['status'=>'error', 'error'=>"Insufficient Balance."];
            }else{
                Account::create([
                    'member_id' => $withdraw->member->id,
                    'title' => "Payment Withdraw from Wallet",
                    'amount' => $withdraw->amount,
                    'type' => 'dr',
                    'display' => 1,
                    'admin_chrg' => $withdraw->chrg,
                    'tds' => 0,
                    'total' => $withdraw->total
                ]);
                $withdraw->done = 1;
                $withdraw->save();
                return ['status'=>"success"];
            }
        }
    }

    public function post_payment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "member_id"     => "required|exists:member,id",
            "title"         => "required",
            "amount"        => "required|numeric",
        ]);

        if ($validator->fails()) {
            return ['status'=>"error", "error"=>$validator->errors()];
        }else{
            $member = Member::findOrFail($request->member_id);
            $balance = $this->acc_bal($member);

            if($request->amount > $balance){
                return ['status'=>'error', 'error'=>"Insufficient Balance."];
            }else{
                Account::create([
                    'member_id' => $request->member_id,
                    'title' => "Payment - ".$request->title,
                    'amount' => $request->amount,
                    'type' => 'dr',
                    'display' => 1,
                    'admin_chrg' => 0,
                    'tds' => 0,
                    'total' => $request->amount
                ]);
                return ['status'=>"success"];
            }
        }
    }

    public function report_reg() { return view('admin.report_reg'); }
    public function get_report_reg(Request $request)
    {
        $from = Carbon::createFromFormat('d/m/Y', $request->get('from_date'));
        $to = Carbon::createFromFormat('d/m/Y', $request->get('to_date'));
        $members = Member::where([['created_at', '>', $from],['created_at', '<', $to]])->get();
        return view('admin.report_reg', compact('members'));
    }
    public function report_epin() { return view('admin.report_epin'); }
    public function get_report_epin(Request $request)
    {
        $from = Carbon::createFromFormat('d/m/Y', $request->get('from_date'));
        $to = Carbon::createFromFormat('d/m/Y', $request->get('to_date'));
        $epins = Epin::where([['created_at', '>', $from],['created_at', '<', $to]])->get();
        return view('admin.report_epin', compact('epins'));
    }

    public function adjustment() { return view('admin.adjustment'); }
    public function adjustment_post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "member_id" => "required|exists:member,id",
            "amount"    => "required|numeric",
            "title"     => "required",
            "type"      => "required",
        ]);

        if ($validator->fails()) {
            return ['status'=>"error", "error"=>$validator->errors()];
        }else{

            $account = Account::create($request->all());
            $account->display = 1;
            $account->save();
            return ['status'=>"done", 'account_id'=>$account->id];
        }
    }
    public function transfer() { return view('admin.transfer'); }
    public function transfer_post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "member_from_id"    => "required|exists:member,id",
            "member_to_id"      => "required|exists:member,id",
            "amount"    => "required|numeric",
            "title"     => "required",
        ]);

        if ($validator->fails()) {
            return ['status'=>"error", "error"=>$validator->errors()];
        }else{
            if($this->acc_bal(Member::find($request->member_from_id)) >= $request->amount){
                $data = ['member_id'=>$request->member_from_id, 'amount'=>$request->amount, 'title'=>$request->title . ' TRANSFER TO: PCW'.$request->member_to_id, 'type'=> 'dr', 'display'=>1];
                $from = Account::create($data);

                $data = ['member_id'=>$request->member_to_id, 'amount'=>$request->amount, 'title'=>$request->title . ' TRANSFER FROM: PCW'.$request->member_from_id, 'type'=> 'cr', 'display'=>1];
                $to = Account::create($data);

                $this->sms(Member::find($request->member_from_id)->mobile, "You have transferred Rs. ".$request->amount." to ID: ".$request->member_to_id." was successful. PlayCardsWell.");
                return ['status'=>"done", 'acc_f'=>$from->id, 'to'=>$to->id];
            }else{
                return ['status'=>'error', 'error'=>"Insufficient Balance."];
            }
        }
    }

    public function pinpoint()
    {
        return view('admin.pinpoint');
    }
    public function post_pinpoint(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "do"        => "required",
            "name"      => "required",
            "mobile"    => "required|size:10",
            "address"   => "required",
            "city"      => "required",
            "state"     => "required",
            "id"        => "required_if:do,edit|exists:pinpoint,id",
        ]);

        if ($validator->fails()) {
            return ['status'=>"error", "error"=>$validator->errors()];
        }else{
            if($request->do == 'add'){
                $pp = PinPoint::create($request->all());
                return ['status'=>"success", 'id'=>$pp->id];
            }else if($request->do == 'edit'){
                $pp = PinPoint::findOrFail($request->id)->update($request->all());
                return ['status'=>"success", 'id'=>$request->id];
            }
        }
    }
    public function delete_pinpoint(Request $request)
    {
        PinPoint::findOrFail($request->id)->delete();
        return ['status'=>"done"];
    }
    public function news()
    {
        return view('admin.news');
    }
    public function post_news(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "body" => "required",
        ]);

        if ($validator->fails()) {
            return ['status'=>"error", "error"=>$validator->errors()];
        }else{
            $pp = News::create(['body'=>$request->body]);
            return ['status'=>"success"];
        }
    }
    public function delete_news(Request $request)
    {
        News::findOrFail($request->id)->delete();
        return ['status'=>"done"];
    }

    public function change_password()
    {
        return view('admin.change_password');
    }

    public function post_change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "password"      => "required",
        ]);

        if ($validator->fails()) {
            return ['status'=>"error", "error"=>$validator->errors()];
        }else{
            $member = Member::find(10001);
            $member->password = $request->password;
            $member->save();
            return ['status'=>'done'];
        }
    }
    public function logout()
    {
        session_destroy();
        return redirect()->route('home');
    }
}
