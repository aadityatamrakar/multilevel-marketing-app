@extends('template.member')

@section('content')
    <div class="container">
        <div class="text-center"><img src="/img/member/member_p.jpeg"/></div>
        <br>
        <div class="col-md-8 col-md-offset-2 panel panel-primary">
            <div class="row" style="border-bottom: 1px solid #999;">
                <div class="col-md-8 col-xs-9">
                    <h3>Welcome: {{ $member->name }}</h3>
                    <h4>Login ID: PCW{{ $member->id }}</h4>
                    <h4>{{ ($member->pv['level']==0)?"Manager":\App\Http\Controllers\Controller::level($member->pv['level']-1, 'name') }}</h4>
                </div>
                <div class="col-md-4 col-xs-3">
                    <span class="pull-right">
                        <img class="img-thumbnail" src="/uploads/member/pp_{{ $member->id }}.jpg" style="height: 100px;" onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/9/9d/Unknown_Member.jpg'" alt="Photo">
                    </span>
                </div>
                <div class="text-center col-xs-12">
                    @if($member->kyc === 1)
                        <h4 class="text-success">KYC Done</h4>
                    @else
                        <h4 class="text-danger">KYC Pending</h4>
                    @endif
                </div>
            </div>
            <div class="row" style="border-bottom: 1px solid #999;">
                <div class="col-xs-4">
                    <h3 class="text-center">Total Active Referral<br>{{ $self_active }}</h3>
                </div>
                <div class="col-xs-4">
                    <h3 class="text-center">Self Team Business<br>{{ $member->pv['activated']*3000 }} PV</h3>
                </div>
                <div class="col-xs-4">
                    <h3 class="text-center">All Team Business<br>{{ $all_team*3000 }} PV</h3>
                </div>
            </div>
            <div class="row" style="border-bottom: 1px solid #999;">
                <div class="col-md-4 col-xs-6">
                    <img src="/img/member/next.png" width="100%" alt="next" />
                </div>
                <div class="col-md-6 col-xs-6 text-center">
                    <h3>{{ \App\Http\Controllers\Controller::level($member->pv['level'], 'name') }}</h3>
                    <h3>Amount: Rs. {{ \App\Http\Controllers\Controller::level($member->pv['level'], 'income') }}</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <h3 class="text-center">Active Referral</h3>
                </div>
                <div class="col-xs-4">
                    <h3 class="text-center">Self Team</h3>
                </div>
                <div class="col-xs-4">
                    <h3 class="text-center">All Team Business</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <h3 class="text-center">1 <img src="{{ $self_active>$member->pv['level']?"/img/member/done.jpeg":"/img/member/dislike.jpeg" }}" width="30px" style="margin-top: -10px;" /></h3>
                </div>
                <div class="col-xs-4">
                    <h3 class="text-center">1 {{ $member->pv['level']==0?"Manager":\App\Http\Controllers\Controller::level($member->pv['level']-1, 'name') }}
                    @if( ($tmp = \App\Member::where('id', $member->pv['highest'])->first()) !== null )
                        @if($tmp->pv->level == 0 && $member->pv['level'] == 0)
                            <img src="/img/member/done.jpeg" width="30px" style="margin-top: -10px;" /></h3>
                        @else
                            <img src="{{ (($tmp->pv->level-1==$member->pv['level']) || ($tmp->pv->level==$member->pv['level']))?"/img/member/done.jpeg":"/img/member/dislike.jpeg" }}" width="30px" style="margin-top: -10px;" /></h3>
                        @endif
                    @else
                        <img src=/img/member/dislike.jpeg width="30px" style="margin-top: -10px;" /></h3>
                    @endif
                </div>
                <div class="col-xs-4">
                    <h3 class="text-center">{{ \App\Http\Controllers\Controller::level($member->pv['level'], 'pv') }} PV <img src="{{ ($all_team*3000)>=\App\Http\Controllers\Controller::level($member->pv['level'], 'pv')?"/img/member/done.jpeg":"/img/member/dislike.jpeg" }}" width="30px" style="margin-top: -10px;" /></h3>
                </div>
                <span class="hide">{!! $member->pv !!}</span>
            </div>
        </div>
    </div>
@endsection