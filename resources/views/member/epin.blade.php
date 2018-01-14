@extends('template.member')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" />
@endsection
@section('content')
    <div class="container">
        <h3>E-PIN Details</h3>
        <hr>
        <table id="tbl" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>PIN</th>
                <th>Amount</th>
                <th>Created</th>
                <th>Status</th>
                <th>Member</th>
            </tr>
            </thead>
            <tbody>
            @foreach(\App\Epin::where('member_id', $_SESSION['member_id'])->orderBy('id', 'desc')->get() as $index=>$epin)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $epin->code }}</td>
                    <td>{{ $epin->value }}</td>
                    <td>{{ \Carbon\Carbon::parse($epin->created_at)->diffForHumans() }}</td>
                    <td>{{ $epin->status }}</td>
                    <td style="text-transform: capitalize;">{{ $epin->reg_id!=null?'PCW'.\App\Member::find($epin->reg_id)->id .' - '. \App\Member::find($epin->reg_id)->name:'-' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function (){
            $("#tbl").dataTable({
                responsive: true
            });
        })
    </script>
@endsection