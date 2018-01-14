@extends('template.member')

@section('content')
    <div class="container">
        <form method="post" onsubmit="return false;" action="" id="frm" class="form-horizontal">
            <fieldset>
                <legend>Package Top-up</legend>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="reg_id">Member ID</label>
                    <div class="col-md-5">
                        <input id="reg_id" name="reg_id" type="text" placeholder="" class="form-control input-md" required="">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="reg_date">Registration Date</label>
                    <div class="col-md-5">
                        <input id="reg_date" name="reg_date" type="text" class="form-control input-md" required="" readonly>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="epin">E-PIN</label>
                    <div class="col-md-5">
                        <input id="epin" name="epin" type="text" class="form-control input-md" required="">
                        <span class="help-block"></span>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-4 control-label" for="save"></label>
                    <div class="col-md-4">
                        <button id="save" name="save" class="btn btn-primary">Topup</button>
                    </div>
                </div>

            </fieldset>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        var mname = '';
        $("#reg_id").on('blur', function (){
            var id = $(this).val().toLowerCase().replace('pcw', '');
            $.ajax({
                url: "{{ route('member.reg_details') }}",
                type: "POST",
                data: {id: id}
            }).done(function (e){
                if(e.p !== null){
                    $("#save").attr('disabled', '');
                    $("#save").html('Already Paid');
                }else{
                    $("#save").removeAttr('disabled');
                    $("#save").html('Submit');
                }
                $("#reg_id").parent().children('.help-block').html("Member Name: "+e.n);
                mname = e.n;
                $("#epin").val(e.a);
                $("#epin").parent().children('.help-block').html("E-PIN Value: "+(parseInt(e.d)>7?"4000":"3000"));
                $("#reg_date").val(e.r.date.substr(0, 10));
                $("#reg_date").parent().children('.help-block').html("Registered "+e.d + " Day(s) Before. ");
            }).fail(function (e){
                $("#reg_date").val("NOT FOUND");
                $("#epin").val("");
                $("#reg_date").parent().children('.help-block').html("");
            });
        })

        $('#save').click(function (){
            if(confirm("Confirm ID Topup of "+mname)){
                var id = $("#reg_id").val().toLowerCase().replace('pcw', '');
                var epin = $("#epin").val();

                $.ajax({
                    url: "{{ route('member.epin.topup') }}",
                    type: "POST",
                    data: {reg_id: id, epin: epin}
                }).done(function (e){
                    if(e.status == 'done'){
                        alert('EPIN Used. Member Package Topup Successfull.');
                        window.location.reload();
                    }else{
                        alert('Error: '+e.error.toString());
                    }
                }).fail(function (e){
                    if(e.status == 404){
                        $("#reg_date").val(e.r.date.substr(0, 10));
                        $("#reg_date").parent().children('.help-block').html("Registered "+e.d + " Day(s) Before. ");
                    }
                });
            }
        })
    </script>
@endsection