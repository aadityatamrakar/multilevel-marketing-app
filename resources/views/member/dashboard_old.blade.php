@extends('template.member')

@section('content')
    <div class="container">
        <div class="text-center"><img src="/img/logow.png"/></div>
        <h3 class="text-center">:: Member Portal ::</h3>
        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">Welcome {{ $member->name }}</div>
                    </div>
                    <table class="table table-responsive table-striped">
                        <tbody>
                        <tr>
                            <th>Member ID</th>
                            <td>{{ $member->id }}</td>
                        </tr>
                        <tr>
                            <th>Total Registered Member</th>
                            <td>{{ $member->pv['members'] }}</td>
                        </tr>
                        <tr>
                            <th>Total Active Member</th>
                            <td>{{ $member->pv['activated'] }}</td>
                        </tr>
                        <tr>
                            <th>Member PV</th>
                            <td>{{ $member->pv['activated']*3000 }}</td>
                        </tr>
                        <tr>
                            <th>Level</th>
                            <td>{{ \App\Http\Controllers\Controller::level($member->pv['level'], 'downline')===0?'Manager':\App\Http\Controllers\Controller::level($member->pv['level'], 'name') }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">Target -> {{ \App\Http\Controllers\Controller::level($member->pv['level'], 'name') }}</div>
                    </div>
                    <table class="table table-responsive table-striped">
                        <tbody>
                        <tr>
                            <th>Next Level</th>
                            <td>{{ \App\Http\Controllers\Controller::level($member->pv['level'], 'name') }}</td>
                        </tr>
                        <tr>
                            <th>Direct Referral</th>
                            <td>1</td>
                        </tr>
                        <tr>
                            <th>Downline</th>
                            <td>{{ \App\Http\Controllers\Controller::level($member->pv['level'], 'downline')===0?'Manager':\App\Http\Controllers\Controller::level($member->pv['level']-1, 'name') }}</td>
                        </tr>
                        <tr>
                            <th>Member PV</th>
                            <td>{{ \App\Http\Controllers\Controller::level($member->pv['level'], 'pv') }}</td>
                        </tr>
                        <tr>
                            <th>Income on Next Level</th>
                            <td>{{ \App\Http\Controllers\Controller::level($member->pv['level'], 'income') }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection