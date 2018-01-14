@extends('template.admin')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" />
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3>EPIN Summary</h3>
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
                    <a href="{{ route('admin.report_epin') }}" class="btn btn-danger">Clear</a>
                </form>
            </div>
        </div>
        @if(isset($epins))
            <hr>
            <table id="member_tbl" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Member ID</th>
                    <th>Code</th>
                    <th>Value</th>
                    <th>Status</th>
                    <th>Registration</th>
                    <th>Gen. By</th>
                </tr>
                </thead>
                <tbody>
                @foreach($epins as $index=>$epin)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($epin->created_at)->format('d/m/Y') }}</td>
                        <td>{{ $epin->member_id }}</td>
                        <td>{{ $epin->code }}</td>
                        <td>{{ $epin->value }}</td>
                        <td>{{ $epin->status }}</td>
                        <td>{{ ($epin->reg_id !== null)?"PCW".$epin->reg_id." - ". \App\Member::find($epin->reg_id)->name:'-' }}</td>
                        <td>{{ $epin->gen_by }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).ready(function (){
            @if(isset($epins))
                $("#member_tbl").dataTable();
            @endif
            $(".datepicker").datepicker();
        });
    </script>
@endsection