@extends('template.member')

@section('content')
    <div class="container">
        <form action="" method="post" id="frm" onsubmit="return false;" class="form-horizontal">
            <fieldset>
                <legend>EPIN Generate</legend>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="balance">Amount Balance (in Rs.)</label>
                    <div class="col-md-5">
                        <input id="balance" name="balance" type="text" value="{{ $acc_bal }}" disabled class="form-control input-md">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="package">Package</label>
                    <div class="col-md-5">
                        <select id="package" name="package" class="form-control">
                            <option value="3000">3000</option>
                            <option value="4000">4000</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="epins">No of EPINS</label>
                    <div class="col-md-5">
                        <input id="epins" name="epins" type="number" min="0" class="form-control input-md" required="">
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="total">Total Amount</label>
                    <div class="col-md-5">
                        <input id="total" name="total" type="text" class="form-control input-md" required="" disabled>
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

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="save"></label>
                        <div class="col-md-4">
                            <button id="save" name="save" class="btn btn-primary">Generate</button>
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
            var package = $("#package").val();
            var epins = $("#epins").val();
            var otp = $("#otp").val();

            $.ajax({
                url: "{{ route('member.epin.generate') }}",
                type: "POST",
                data: {package: package, epins: epins, otp: otp}
            }).done(function (e){
                if(e.status == 'done'){
                    alert('EPINs Generated.');
                    window.location.href = '{{ route('member.epin.details') }}';
                }else{
                    alert('Error: '+e.error);
                }
            });
        });

        $("#epins").on('keyup', function (){
            var e = $(this).val();
            var p = parseInt($("#package").val());
            var t = e*p;
            $("#total").val(t);
            var b = parseInt($("#balance").val());
            if(t > b) { $("#save").attr('disabled', ''); }
            else { $("#save").removeAttr('disabled'); }
        })
    </script>
@endsection