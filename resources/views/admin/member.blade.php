@extends('template.admin')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" />
@endsection

@section('content')
    <div class="container">
        <h3>Members List</h3>

        <table id="member_tbl" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>S ID</th>
                <th>Name</th>
                <th>Active</th>
                <th>PV</th>
                <th>Join Date</th>
                <th>Act. Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            {{--@foreach(\App\Member::all() as $index=>$member)--}}
                {{--<tr>--}}
                    {{--<td>{{ "PCW".$member->id }}</td>--}}
                    {{--<td>{{ "PCW".$member->s_id }}</td>--}}
                    {{--<td>{{ $member->name }}</td>--}}
                    {{--<td>{{ $member->reg_pin!==null?"Active":"Non-Active" }}</td>--}}
                    {{--<td>{{ $member->pv['all_act']*3000 }}</td>--}}
                    {{--<td>{{ \Carbon\Carbon::parse($member->created_at)->format('d/m/Y') }}</td>--}}
                    {{--<td>{{ $member->reg_pin!==null?\Carbon\Carbon::parse($member->reg_pin['updated_at'])->format('d/m/Y'):"NA" }}</td>--}}
                    {{--<td>--}}
                        {{--<a href="{{ route('admin.member.view', ['id'=>$member->id]) }}" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-folder-open"></i> View</a>--}}
                        {{--{!! $member->reg_pin===null?'<button data-toggle="delete_member" data-target="'. $member->id .'" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i> Del</button>':''  !!}--}}
                    {{--</td>--}}
                {{--</tr>--}}
            {{--@endforeach--}}

            @foreach($members as $index=>$member)
                <tr>
                    <td>{{ "PCW".$member->id }}</td>
                    <td>{{ "PCW".$member->s_id }}</td>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->updated_at!==null?"Active":"Non-Active" }}</td>
                    <td>{{ $member->all_act*3000 }}</td>
                    <td>{{ \Carbon\Carbon::parse($member->created_at)->format('d/m/Y') }}</td>
                    <td>{{ $member->updated_at!==null?\Carbon\Carbon::parse($member->updated_at)->format('d/m/Y'):"NA" }}</td>
                    <td>
                        <a href="{{ route('admin.member.view', ['id'=>$member->id]) }}" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-folder-open"></i> View</a>
                        {!! $member->updated_at===null?'<button data-toggle="delete_member" data-target="'. $member->id .'" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i> Del</button>':''  !!}
                    </td>
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
            $("#member_tbl").dataTable();
        });

        $('[data-toggle="delete_member"]').click(function (e){
            var b = $(this);
            b.attr('disabled', '');
            var id = b.data('target');
            if(confirm("Confirm Delete ID: PCW"+id+" ? ")){
                $.ajax({
                    url: "{{ route('admin.member.delete') }}",
                    type: "POST",
                    data: {id: id}
                }).done(function (res){
                    if(res.status == 'done'){
                        b.parent().parent().remove();
                    }else if(res.status == 'error'){
                        alert(res.error);
                    }
                }).fail(function (err){
                    console.log('Something Went Wrong.');
                    if(err.status == 404){
                        alert('Member not found.');
                    }
                }).always(function (){
                    b.removeAttr('disabled');
                });
            }else{
                b.removeAttr('disabled');
            }
        });
    </script>
@endsection