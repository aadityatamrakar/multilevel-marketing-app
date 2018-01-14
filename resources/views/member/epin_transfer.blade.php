@extends('template.member')

@section('content')
    <div class="container">
        <form id="frm" class="form-horizontal" action="" method="post" onsubmit="return false;">
            <fieldset>

                <!-- Form Name -->
                <legend>EPIN Transfer</legend>

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
                    <label class="col-md-4 control-label" for="pin">Select PIN</label>
                    <div class="col-md-5">
                        <select id="pin" name="pin" class="form-control">
                            <option value="3000">3000</option>
                            <option value="4000">4000</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="available">Available</label>
                    <div class="col-md-5">
                        <input id="available" name="available" value="{{ $epins[3000] }}" disabled type="text" class="form-control input-md" >
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="epins">No of E-PINS</label>
                    <div class="col-md-5">
                        <input id="epins" name="epins" type="text" placeholder="" class="form-control input-md" required="">

                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="save"></label>
                    <div class="col-md-4">
                        <button id="save" name="save" class="btn btn-primary">Transfer</button>
                    </div>
                </div>

            </fieldset>
        </form>

    </div>
@endsection

@section('scripts')
    <script>
        var mname = '';

        $("#save").click(function (){
            if(confirm("Confirm Transfer Pins to "+mname)){
                var btn = $(this);
                btn.attr('disabled', '');

                var frmData = $("#frm").serializeArray();
                $.ajax({
                    url: "{{ route('member.epin.transfer') }}",
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
                        alert("EPINs Transfered.");
                        window.location.reload();
                    }
                    btn.removeAttr('disabled');
                }).fail(function (){
                    btn.removeAttr('disabled');
                })
            }
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
                mname = e;
                t.parent().children('.help-block').html("Member Name: "+e+" <a href='#' class='btn btn-xs btn-default' onclick=\"window.location.reload()\">Reset</a>");
                t.attr('readonly', '');
            }).fail(function (err){
                if (err.status == 404){
                    t.parent().children('.help-block').html("Member Not Found.");
                }
            });
        });

        $("#pin").on('change', function (){
            var pin = {'3000': '{{ $epins[3000] }}', '4000': '{{ $epins['4000'] }}'};
            $("#available").val(pin[$(this).val()]);
        });
    </script>
@endsection