@extends('template.member')

@section('content')
    <div class="container">
        <h3>Direct Team <small>{{ \App\Member::where('s_id', $_SESSION['member_id'])->count() }} members</small></h3>
        <hr>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Active</th>
                <th>Self PV</th>
                <th>All PV</th>
                <th>Level</th>
                <th>Joining Date</th>
                <th>Activation Date</th>
            </tr>
            </thead>
            <tbody>
            @foreach(\App\Member::where('s_id', $_SESSION['member_id'])->get() as $member)
                <tr>
                    <td>PCW{{ $member->id }}</td>
                    <td style="text-transform: capitalize;">{{ $member->name }}</td>
                    <td>{{ $member->reg_pin!==null?"Active":"Non-Active" }}</td>
                    <td>{{ $member->pv['activated']*3000 }}</td>
                    <td>{{ $member->pv['all_act']*3000 }}</td>
                    <td>{{ \App\Http\Controllers\Controller::level_name($member->pv['level']) }}</td>
                    <td>{{ \Carbon\Carbon::parse($member->created_at)->format('d/m/Y') }}</td>
                    @if($member->reg_pin!==null)
                        <td>{{ \Carbon\Carbon::parse($member->reg_pin['updated_at'])->format('d/m/Y') }}</td>
                    @else
                        <td>NA</td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection