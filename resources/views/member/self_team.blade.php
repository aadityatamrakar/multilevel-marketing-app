@extends('template.member')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" />
@endsection
@section('content')
    <div class="container">
        <h3>Self Team</h3>
        <hr>
        <table id="tbl" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>S.ID</th>
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

            @foreach($members as $member)
                <tr>
                    <td>PCW{{ $member['id'] }}</td>
                    <td>PCW{{ $member['s_id'] }}</td>
                    <td style="text-transform: capitalize;">{{ $member['name'] }}</td>
                    @if(\App\Member::find($member['id'])->reg_pin !== null)
                        <td>Active</td>
                        <span class="hide">{{ $active++ }}</span>
                    @else
                        <td>Non-Active</td>
                    @endif
                    <td>{{ \App\Member::find($member['id'])->pv['activated']*3000 }}</td>
                    <td>{{ \App\Member::find($member['id'])->pv['all_act']*3000 }}</td>
                    <td>{{ \App\Http\Controllers\Controller::level_name(\App\Member::find($member['id'])->pv['level']) }}</td>
                    <td>{{ \Carbon\Carbon::parse($member->created_at)->format('d/m/Y') }}</td>
                    @if($member->reg_pin!==null)
                        <td>{{ \Carbon\Carbon::parse($member->reg_pin['updated_at'])->format('d/m/Y') }}</td>
                    @else
                        <td>NA</td>
                    @endif
                </tr>
            @endforeach
            </tbody>
            <tfoot><tr>
                <td colspan="9">Total Active: {{ $active }}</td>
            </tr></tfoot>
        </table>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function (){
            $("#tbl").dataTable();
        })

    </script>
@endsection