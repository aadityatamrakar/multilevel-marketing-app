@extends('template.member')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" />
@endsection
@section('content')
    <div class="container">
        <h3>Account Details</h3>
        <hr>
        <table id="tbl" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Date</th>
                <th>Title</th>
                <th>Credit</th>
                <th>Debit</th>
            </tr>
            </thead>
            <tbody>
            @foreach(\App\Account::where([['member_id', $_SESSION['member_id']], ['display', 1]])->orderBy('id', 'desc')->get() as $index=>$account)
                <tr class="{{ $account->type=='cr'?"text-success":"text-danger" }}">
                    <td>{{ \Carbon\Carbon::parse($account->created_at)->format('d/m/Y') }}</td>
                    <td>{{ $account->title }}</td>
                    <td>{{ $account->type==='cr'?'₹ '.$account->amount:'' }}</td>
                    <td>{{ $account->type==='dr'?'₹ '.$account->amount:'' }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td>₹ {{ \App\Account::where('member_id', $_SESSION['member_id'])->where([['type', 'cr'], ['display', 1]])->sum('amount') }}</td>
                <td>₹ {{ \App\Account::where('member_id', $_SESSION['member_id'])->where([['type', 'cr'], ['display', 1]])->sum('amount') }}</td>
            </tr>
            </tfoot>
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