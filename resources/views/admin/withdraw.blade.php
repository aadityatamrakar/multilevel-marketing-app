@extends('template.admin')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" />
@endsection
@section('content')
    <div class="container">
        <h2>Wallet Payment</h2>
        <table id="tbl" class="table table-striped">
            <thead>
            <tr>
                <th>M #ID</th>
                <th>Name</th>
                <th>Balance</th>
                <th>Request Amount</th>
                <th>Net Amount</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php $totalr = $totala = 0; ?>
            @foreach(\App\Withdraw::where('done', 0)->get() as $w)
                <tr>
                    <td>PCW{{ $w->member_id }}</td>
                    <td><a class="btn btn-xs btn-primary" target="_blank" href="{{ route('admin.member.view', ["id"=>$w->member_id]) }}">{{ $w->member->name }}</a></td>
                    <td>₹ {{ (new \App\Http\Controllers\Controller)->acc_bal($w->member) }}</td>
                    <td>₹ <?php $totalr += $w->total ?>{{ $w->total }}</td>
                    <td>₹ <?php $totala += $w->amount ?>{{ $w->amount }}</td>
                    <td><button data-toggle="paydone" data-target="{{ $w->id }}" class="btn btn-xs btn-primary">Done</button></td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th>₹ {{ $totalr }}</th>
                <th>₹ {{ $totala }}</th>
                <th></th>
            </tr>
            </tfoot>
        </table>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function (){
            $("#tbl").dataTable();
        });

        $('[data-toggle="paydone"]').click(function (){
            var btn = $(this);
            btn.attr('disabled', '');
            var pid = btn.data('target');

            $.ajax({
                url: "{{ route('admin.withdraw') }}",
                type: "POST",
                data: {pid: pid}
            }).done(function (res){
                if(res.status == 'success'){
                    btn.html('Withdraw Done!');
                }else {
                    if(res.status == 'error'){
                        alert('Error: ' + res.error);
                    }
                    btn.removeAttr('disabled');
                }
            })
        });
    </script>
@endsection