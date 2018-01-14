@extends('template.admin')

@section('content')
    <div class="container">
        <form method="post" action="" onsubmit="return false;" id="frm" class="form-horizontal">
            <fieldset>
                <legend>Member to Member Transfer</legend>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="member_from">Member ID (From)</label>
                    <div class="col-md-5">
                        <input style="text-transform: uppercase;" id="member_from" name="member_from" type="text" class="form-control input-md" required="">
                        <input id="member_from_id" name="member_from_id" type="hidden">
                        <span class="help-block">Member Name: </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="member_to">Member ID (To)</label>
                    <div class="col-md-5">
                        <input style="text-transform: uppercase;" id="member_to" name="member_to" type="text" class="form-control input-md" required="">
                        <input id="member_to_id" name="member_to_id" type="hidden">
                        <span class="help-block">Member Name: </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="title">Title</label>
                    <div class="col-md-5">
                        <input id="title" name="title" type="text" placeholder="Subject" class="form-control input-md" required="">
                        <span class="help-block">Adjustment Reason</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="amount">Amount</label>
                    <div class="col-md-5">
                        <input id="amount" name="amount" type="text" placeholder="in Rs." class="form-control input-md" required="">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="save"></label>
                    <div class="col-md-4">
                        <button id="save" name="save" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        $("#save").click(function (){
            var btn = $(this);
            btn.attr('disabled', '');
            var frmData = $("#frm").serializeArray();
            $.ajax({
                url: "{{ route('admin.wallet.transfer') }}",
                type: "POST",
                data: frmData
            }).done(function (res){
                $(".has-error").removeClass('has-error');
                $(".invalid-feedback").html('');

                if(res.status === 'error'){
                    $.each(res.error, function(i, v){
                        $("#"+i).parent().parent().addClass('has-error');
                        $("#"+i).parent().children("span.help-block").html(v).addClass('invalid-feedback');
                    });
                }else if(res.status === 'done'){
                    alert("Account Transaction Added.");
                    window.location.reload();
                }
                btn.removeAttr('disabled');
            }).fail(function (){
                btn.removeAttr('disabled');
            })
        })
        var available_bal = 0;
        $("#member_from").on('blur', function (){
            var t = $("#member_from");
            var id = $("#member_from").val();

            if(id.toLowerCase().indexOf('pcw') !== -1){
                id = id.toLowerCase().replace('pcw', '');
                $("#member_from_id").val(id);
            }
            $.ajax({
                url: "{{ route('member.reg_details') }}",
                type: "POST",
                data: {id: id}
            }).done(function (e){
                t.parent().children('.help-block').html("Member Name: "+e.n);
                available_bal = parseInt(e.acc);
                $("#amount").parent().children('.help-block').html("Account Balance: Rs. "+e.acc);
            }).fail(function (err){
                if (err.status == 404){
                    t.parent().children('.help-block').html("Member Not Found.");
                }
            });
        });
        $("#member_to").on('blur', function (){
            var t = $("#member_to");
            var id = $("#member_to").val();

            if(id.toLowerCase().indexOf('pcw') !== -1){
                id = id.toLowerCase().replace('pcw', '');
                $("#member_to_id").val(id);
            }
            $.ajax({
                url: "{{ route('member.reg_details') }}",
                type: "POST",
                data: {id: id}
            }).done(function (e){
                t.parent().children('.help-block').html("Member Name: "+e.n);
            }).fail(function (err){
                if (err.status == 404){
                    t.parent().children('.help-block').html("Member Not Found.");
                }
            });
        });

        $("#amount").on('keyup', function (){
            var amount = $(this).val();
            if(amount > available_bal){
                $("#save").attr('disabled', '');
            }else{
                $("#save").removeAttr('disabled');
            }
        })
    </script>
@endsection