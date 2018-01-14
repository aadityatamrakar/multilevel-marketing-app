@extends('template.admin')

@section('content')
    <div class="container">
        <form method="post" action="" onsubmit="return false;" id="frm" class="form-horizontal">
            <fieldset>
                <legend>Wallet Adjustment</legend>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="member">Member ID</label>
                    <div class="col-md-5">
                        <input id="member" name="member" type="text" class="form-control input-md" required="">
                        <input id="member_id" name="member_id" type="hidden">
                        <span class="help-block">Member Name: </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="type">Adjustment</label>
                    <div class="col-md-5">
                        <select id="type" name="type" class="form-control">
                            <option value="cr">(+) Credit</option>
                            <option value="dr">(-) Debit</option>
                        </select>
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
                url: "{{ route('admin.wallet.adjustment') }}",
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

        $("#member").on('blur', function (){
            var t = $("#member");
            var id = $("#member").val();

            if(id.toLowerCase().indexOf('pcw') !== -1){
                id = id.toLowerCase().replace('pcw', '');
                $("#member_id").val(id);
            }
            $.ajax({
                url: "{{ route('member.reg_details') }}",
                type: "POST",
                data: {id: id}
            }).done(function (e){
                t.parent().children('.help-block').html("Member Name: "+e.n+" <a href='#' class='btn btn-xs btn-default' onclick=\"window.location.reload()\">Reset</a>");
                $("#amount").parent().children('.help-block').html("Account Balance: Rs. "+e.acc);
                t.attr('readonly', '');
            }).fail(function (err){
                if (err.status == 404){
                    t.parent().children('.help-block').html("Member Not Found.");
                }
            });
        });
    </script>
@endsection