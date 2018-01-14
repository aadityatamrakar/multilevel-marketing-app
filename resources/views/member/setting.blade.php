@extends('template.member')

@section('content')
    <div class="container">
        <form class="form-horizontal" method="post" action="" onsubmit="return false" id="frm">
            <fieldset>
                <legend>Change Password</legend>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="password">Password</label>
                    <div class="col-md-5">
                        <input id="password" name="password" type="password" placeholder="" class="form-control input-md" required="">

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="re_password">Re-Enter Password</label>
                    <div class="col-md-5">
                        <input id="re_password" name="re_password" type="password" placeholder="" class="form-control input-md" required="">

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="save"></label>
                    <div class="col-md-4">
                        <button id="save" name="save" class="btn btn-primary">Change</button>
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
                url: "{{ route('member.setting') }}",
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
                    alert("Password Changed.");
                    window.location.href = "{{ route('member.dashboard') }}";
                }
                btn.removeAttr('disabled');
            }).fail(function (){
                btn.removeAttr('disabled');
            })
        })
    </script>
@endsection