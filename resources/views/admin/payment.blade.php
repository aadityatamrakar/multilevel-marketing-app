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
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php $total = 0; ?>
            @foreach($wallet as $m)
                @if( ($m->cr - $m->dr) != 0)
                    <tr>
                        <td>PCW{{ $m->member_id }}</td>
                        <td>{{ $m->name }}</td>
                        <td>₹ {{ $m->cr - $m->dr }} <?php $total += ($m->cr - $m->dr) ?></td>
                        <td><button class="btn btn-xs btn-primary" data-amount="{{ $m->cr - $m->dr }}" data-member="{{ $m->member_id }}" data-toggle="modal" data-target="#paymember">Pay</button></td>
                    </tr>
                @endif
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th>₹ {{ $total }}</th>
                <th></th>
            </tr>
            </tfoot>
        </table>
    </div>

    <div class="modal fade" id="paymember" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Pay Member</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <fieldset>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="amount">Amount</label>
                                <div class="col-md-5">
                                    <input id="member_id" name="member_id" type="hidden">
                                    <input id="amount" name="amount" type="text" placeholder="" class="form-control input-md" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="title">Title</label>
                                <div class="col-md-5">
                                    <input id="title" name="title" type="text" placeholder="" class="form-control input-md" required="">
                                </div>
                            </div>
                        </fieldset>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="pay_member" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function (){
            $("#tbl").dataTable();
        });

        $('#paymember').on('show.bs.modal', function (event) {
            var btn = $(event.relatedTarget);
            var target = btn.data('member');
            $("#member_id").val(target);
            $("#amount").val(btn.data('amount'));
            $("#title").val("Paid to member by Cash");
        });

        $("#pay_member").click(function (){
            var btn = $(this);
            btn.attr('disabled', '');
            var amount= $("#amount").val();
            var mid = $("#member_id").val();
            var title = $("#title").val();

            $.ajax({
                url: "{{ route('admin.payment') }}",
                type: "POST",
                data: {member_id: mid, amount: amount, title: title}
            }).done(function (res){
                if(res.status == 'success'){
                    alert('Payment Done.');
                    btn.html('done');
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