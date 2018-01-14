@extends('template.member')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" />
@endsection
@section('content')
    <div class="container">
        <form id="frm" class="form-horizontal" onsubmit="return false;" action="{{ route('member.account.withdraw') }}" method="post" >
            <fieldset>
                <legend>Withdraw Funds</legend>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="available">Available Funds</label>
                    <div class="col-md-5">
                        <input id="available" name="available" readonly value="₹ {{ $available_funds }}" type="text" class="form-control input-md" required="">
                        <span class="help-block">Available Funds = Wallet Balance - Requested Funds</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="total">Withdraw Amount</label>
                    <div class="col-md-5">
                        <input id="total" name="total" type="number" max="{{ $available_funds }}" class="form-control input-md" required="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="chrg">Withdraw Charge</label>
                    <div class="col-md-5">
                        <input id="chrg" name="chrg" readonly type="text" class="form-control input-md" required="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="amount">Net Amount</label>
                    <div class="col-md-5">
                        <input id="amount" name="amount" readonly type="text" class="form-control input-md" required="">
                        <span class="help-block">You will receive this net amount.</span>
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
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function (){
            window.history.pushState("", "", '{{ route('member.account.withdraw') }}');

            $("#total").on('blur', function () {
                var total = $(this).val();
                var chrg = total*0.05;
                var amount = total-chrg;

                $("#chrg").val('₹ '+chrg);
                $("#amount").val('₹ '+amount);
            })
        });

        $("#save").click(function (){
            var total = $("#total").val();
            var chrg = total*0.05;
            var amount = total-chrg;
            if ( confirm("Withdraw Amount: ₹ "+ total+ ", Withdrawal Charge: ₹ "+chrg + ", Net Amount: ₹ "+ amount) ){

                $.ajax({
                    url : "{{ route('member.account.withdraw') }}",
                    type: "POST",
                    data: {total: total}
                }).done(function (res){
                    if(res.status == 'done'){
                        alert("Withdrawal Request has been saved successfully.");
                        window.location.reload();
                    }else{
                        alert(res.error.total[0]);
                    }
                })
            }
        });
    </script>
@endsection