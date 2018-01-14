@extends('template.admin')

@section('styles')
    <style>
        .box{
            border: 1px solid #34b728;
            box-shadow: 0px 0px 3px #999;
        }
        @media(max-width: 768px){
            .row{
                padding: 0px 15px;
            }
        }
    </style>
@endsection

@section('content')

    <div class="container">
        <h1 class="text-center">Welcome to Admin Panel</h1>

        <div class="row">
            <div class="col-md-3 box text-center">
                <h1>{{ \App\Member::all()->count() }}</h1>
                <h3>Total Members</h3>
            </div>
            <div class="col-md-3 box text-center">
                <h1>{{ \App\Epin::where('reg_id', '!=', null)->count() }}</h1>
                <h3>Active Members</h3>
            </div>
            <div class="col-md-3 box text-center">
                <h1>{{ \App\Member::where(DB::raw('DATE_FORMAT(created_at, \'%d/%m/%Y\')'), date('d/m/Y'))->count() }}</h1>
                <h3>Registration Today</h3>
            </div>
            <div class="col-md-3 box text-center">
                <h1>{{ \App\Epin::where(DB::raw('DATE_FORMAT(created_at, \'%d/%m/%Y\')'), date('d/m/Y'))->count() }}</h1>
                <h3>EPIN Gen. Today</h3>
            </div>
            <div class="col-md-3 box">
                <h3 class="text-center">KYC Uploaded</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(\Illuminate\Support\Facades\DB::select('SELECT id,name,kyc_s,kyc FROM `member` where kyc_s=\'uploaded\' and (kyc is null or kyc!=1)') as $m)
                        <tr>
                            <td><a href="{{ route('admin.member.view', ["id"=>$m->id]) }}" class="btn btn-xs"><i class="glyphicon glyphicon-folder-open"></i> {{ $m->id }}</a></td>
                            <td>{{ $m->name }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>




@endsection