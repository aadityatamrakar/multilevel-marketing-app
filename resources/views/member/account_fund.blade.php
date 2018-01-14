@extends('template.member')

@section('content')
    <div class="container">
        <form id="frm" class="form-horizontal" action="" method="post" onsubmit="return false;">
            <fieldset>

                <!-- Form Name -->
                <legend>Funds Transfer</legend>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="member">Member ID</label>
                    <div class="col-md-5">
                        <input style="text-transform: uppercase;" id="member" name="member" type="text" placeholder="" class="form-control input-md" required="">
                        <input id="member_id" name="member_id" type="hidden">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="available">Available Balance (in Rs.)</label>
                    <div class="col-md-5">
                        <input id="available" name="available" value="{{ $available }}" disabled type="text" class="form-control input-md" >
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="amount">Amount (in Rs.)</label>
                    <div class="col-md-5">
                        <input id="amount" name="amount" type="number" class="form-control input-md" required="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="get_otp"></label>
                    <div class="col-md-4">
                        <button id="get_otp" name="get_otp" class="btn btn-primary">Submit</button>
                    </div>
                </div>

                <div class="otp_box hide">
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="otp">OTP Recieved</label>
                        <div class="col-md-5">
                            <input id="otp" name="otp" type="number" class="form-control input-md" required="">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <!-- Button -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="save"></label>
                        <div class="col-md-4">
                            <button id="save" name="save" class="btn btn-primary">Transfer</button>
                        </div>
                    </div>
                </div>

            </fieldset>
        </form>

    </div>
@endsection

@section('scripts')
    <script>
        $("#get_otp").click(function (){
            var btn = $(this);
            btn.attr('disabled', '');
            $.ajax({
                url: "{{ route('member.otp') }}"
            }).done(function (e){
                $(".otp_box").removeClass('hide');
            });
        })
        $("#save").click(function (){
            var btn = $(this);
            btn.attr('disabled', '');
            var frmData = $("#frm").serializeArray();
            $.ajax({
                url: "{{ route('member.account.fundtransfer') }}",
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
                    alert("Funds Transfered.");
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
                url: "{{ route('member_name') }}",
                type: "POST",
                data: {id: id}
            }).done(function (e){
                t.parent().children('.help-block').html("Member Name: "+e+" <a href='#' class='btn btn-xs btn-default' onclick=\"window.location.reload()\">Reset</a>");
                t.attr('readonly', '');
            }).fail(function (err){
                if (err.status == 404){
                    t.parent().children('.help-block').html("Member Not Found.");
                }
            });
        });

        $("#amount").on('keyup', function (){
            if($(this).val() > parseInt($("#available").val())){
                $("#save").attr('disabled', '');
            }else{
                $("#save").removeAttr('disabled');
            }
        });
    </script>
@endsection