@extends('template.admin')

@section('content')
    <div class="container">
        <form id="frm" class="form-horizontal" action="" method="post" onsubmit="return false;">
            <fieldset>
                <!-- Form Name -->
                <legend>EPIN Generate</legend>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="member_id">Member ID</label>
                    <div class="col-md-5">
                        <input id="member_id" name="member_id" type="text" placeholder="" class="form-control input-md" required="">
                        <span class="help-block"></span>
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="quantity">Quantity</label>
                    <div class="col-md-5">
                        <input id="quantity" name="quantity" type="text" placeholder="" class="form-control input-md" required="">
                        <span class="help-block"></span>
                    </div>
                </div>

                <!-- Select Basic -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="value">Value</label>
                    <div class="col-md-4">
                        <select id="value" name="value" class="form-control">
                            <option value="3000">3000</option>
                            <option value="4000">4000</option>
                        </select>
                        <span class="help-block"></span>
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="total">Total Amount (in Rs.)</label>
                    <div class="col-md-5">
                        <input id="total" readonly name="total" type="text" placeholder="" class="form-control input-md" required="">
                        <span class="help-block"></span>
                    </div>
                </div>

                <!-- Button -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="save"></label>
                    <div class="col-md-4">
                        <button id="save" name="save" class="btn btn-primary">Save</button>
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
            url: "{{ route('admin.epin') }}",
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
                alert("EPINs Added.");
                window.location.reload();
            }
            btn.removeAttr('disabled');
        }).fail(function (){
            btn.removeAttr('disabled');
        })
    })
    $("#member_id").on('blur', function (){
        var t = $("#member_id");
        var id = $("#member_id").val();

        if(id.toLowerCase().indexOf('pcw') !== -1){
            id = id.toLowerCase().replace('pcw', '');
            $("#member_id").val(id);
        }
        $.ajax({
            url: "{{ route('member_name') }}",
            type: "POST",
            data: {id: id}
        }).done(function (e){
            t.parent().children('.help-block').html("Member Name: "+e);
            t.attr('readonly', '');
        }).fail(function (err){
            if (err.status == 404){
                t.parent().children('.help-block').html("Member Not Found.");
            }
        });
    });

    $("#quantity").on('change', function (){
        update_amount();
    });

    $("#value").on('change', function (){
        update_amount();
    });

    function update_amount(){
        var t = $("#quantity");
        $("#total").val(t.val() * parseInt($("#value").val()));
    }
</script>
@endsection