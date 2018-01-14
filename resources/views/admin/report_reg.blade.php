@extends('template.admin')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" />
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3>ID Registration</h3>
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
                    <a href="{{ route('admin.report_reg') }}" class="btn btn-danger">Clear</a>
                </form>
            </div>
        </div>
        @if(isset($members))
            <hr>
            <table id="member_tbl" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>S ID</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Active</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($members as $index=>$member)
                    <tr>
                        <td>{{ "PCW".$member->id }}</td>
                        <td>{{ "PCW".$member->s_id }}</td>
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->mobile }}</td>
                        <td>{{ $member->reg_pin!==null?"Active":"Non-Active" }}</td>
                        <td>
                            <a href="{{ route('admin.member.view', ['id'=>$member->id]) }}" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-folder-open"></i> View</a>
                            <a href="{{ route('admin.member.edit', ['id'=>$member->id]) }}" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                            <button data-toggle="delete_member" data-target="{{ $member->id }}" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i> Del</button>
                        </td>
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
            @if(isset($members))
                $("#member_tbl").dataTable();
            @endif
            $(".datepicker").datepicker();
        });
    </script>
@endsection