@extends('template.member')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" />
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3>Account Statement</h3>
            </div>
            <div class="col-md-6" style="margin-top: 20px;">
                <form method="post" action="" class="form-inline">
                    <div class="form-group">
                        <label for="from">From</label>
                        <input name="from_date" value="{{ \Illuminate\Support\Facades\Request::has('from_date')?\Illuminate\Support\Facades\Request::get('from_date'):'' }}" type="text" class="form-control datepicker" data-date-format="dd/mm/yyyy" id="from" required>
                    </div>
                    <div class="form-group">
                        <label for="to">to</label>
                        <input name="to_date" value="{{ \Illuminate\Support\Facades\Request::has('to_date')?\Illuminate\Support\Facades\Request::get('to_date'):'' }}" type="text" class="form-control datepicker" id="to" data-date-format="dd/mm/yyyy" required>
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
                <th>Date</th>
                <th>Credit</th>
                <th>Debit</th>
                <th>Balance</th>
            </tr>
            </thead>
            <tbody>
            @foreach(array_reverse($data) as $date=>$account)
                <tr>
                    <td><a class="btn btn-xs btn-default" href="{{ route('member.account.payout', ['date'=>$date]) }}"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;{{ $date }}</a></td>
                    <td class="text-success">{{ isset($account['cr'])?'₹ '.$account['cr']:'' }}</td>
                    <td class="text-danger">{{ isset($account['dr'])?'₹ '.$account['dr']:'' }}</td>
                    <td class="{{ ($account['balance']>0)?"text-success":"text-danger" }}">₹ {{ $account['balance'] }}</td>
                </tr>
            @endforeach
            </tbody>
            @if($b > 0 || $b < 0)
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right">Final Balance {{ (\Illuminate\Support\Facades\Request::has('to_date')?"on ".\Illuminate\Support\Facades\Request::get('to_date'):"") }}</td>
                    <td class="{{ ($b>0)?"text-success":"text-danger" }}">₹ {{ $b }}</td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).ready(function (){
            $("#tbl").dataTable({
                responsive: true,
                "ordering": false,
                "bSort" : false
            });
            $(".datepicker").datepicker();
        })
    </script>
@endsection