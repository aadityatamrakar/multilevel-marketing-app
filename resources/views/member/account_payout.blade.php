@extends('template.member')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" />
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3>Account Payout</h3>
            </div>
            <div class="col-md-6" style="margin-top: 20px;">
                <form method="get" action="" class="form-inline">
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input name="date" value="{{ \Illuminate\Support\Facades\Request::has('date')?\Illuminate\Support\Facades\Request::get('date'):date('d/m/Y') }}" type="text" class="form-control datepicker" id="to" data-date-format="dd/mm/yyyy" required>
                    </div>
                    <button type="submit" class="btn btn-success">Get</button>
                    <a href="{{ route('member.account.statement') }}" class="btn btn-xs btn-danger">Clear</a>
                </form>
            </div>
        </div>
        <hr>
        <table id="tbl" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Type</th>
                <th>Title</th>
                <th>Amount</th>
                <th>Admin Charge</th>
                <th>TDS</th>
                <th>Net Amt.</th>
            </tr>
            </thead>
            <tbody>
            @foreach($accounts as $account)
                <tr class="{{ $account->type==='cr'?"success":"danger" }}">
                    <td>{{ $account->type==='cr'?"Credited":"Debited" }}</td>
                    <td>{{ $account->title }}</td>
                    <td>₹ {{ ($account->amount+$account->admin_chrg+$account->tds) }}</td>
                    <td>{{ $account->admin_chrg?"₹ ".$account->admin_chrg:'-' }}</td>
                    <td>{{ $account->tds?"₹ ".$account->tds:'-' }}</td>
                    <td class="{{ $account->type==='cr'?"text-success":"text-danger" }}"><span>({{ $account->type==='cr'?"+":"-" }})</span> ₹ {{ $account->amount }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).ready(function (){
            $("#tbl").dataTable({
                responsive: true
            });
            $(".datepicker").datepicker();
        })
    </script>
@endsection