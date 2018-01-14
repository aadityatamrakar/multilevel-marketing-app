@extends('template.admin')

@section('content')
    <div class="container">
        <form class="form-horizontal" onsubmit="return false;" method="post" action="" id="reg_form">
            <fieldset>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="s_id">Member ID</label>
                    <div class="col-md-5">
                        <input disabled type="text" class="form-control input-md" value="PCW{{ $member->id }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="s_id">Sponsor ID</label>
                    <div class="col-md-5">
                        <input disabled type="text" class="form-control input-md" value="PCW{{ $member->s_id?:'' }}">
                        <span class="help-block">Sponsor Name: {{ $member->sponsor?$member->sponsor->name:'' }}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="name">Name</label>
                    <div class="col-md-5">
                        <input id="name" name="name" type="text" value="{{ $member->name }}" class="form-control input-md" required="">
                        <span class="help-block">Your Name</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="father_name">Father Name</label>
                    <div class="col-md-5">
                        <input id="father_name" name="father_name" type="text" value="{{ $member->father_name }}" class="form-control input-md" required="">
                        <span class="help-block">Father Name</span>
                    </div>
                </div>
                <!-- dob_d, dob_m, dob_y -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="dob">DOB</label>
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-xs-4">
                                <select id="dob_d" name="dob_d" class="form-control">
                                    <option value="">date</option>
                                    @for($i=1; $i<32; $i++)
                                        <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                    @endfor
                                </select>
                                <span class="help-block"></span>
                            </div>
                            <div class="col-xs-4">
                                <select id="dob_m" name="dob_m" class="form-control">
                                    <option value="">month</option>
                                    @for($i=1; $i<13; $i++)
                                        <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                    @endfor
                                </select>
                                <span class="help-block"></span>
                            </div>
                            <div class="col-xs-4">
                                <select id="dob_y" name="dob_y" class="form-control">
                                    <option value="">year</option>
                                    @for($i=1900; $i<date('Y'); $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="mobile">Mobile</label>
                    <div class="col-md-5">
                        <input id="mobile" name="mobile" type="text" value="{{ $member->mobile }}" class="form-control input-md" required="">
                        <span class="help-block">10 Digit Mobile No without +91 or 0</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="paytm_no">PayTm No</label>
                    <div class="col-md-5">
                        <input id="paytm_no" name="paytm_no" type="text" value="{{ $member->paytm_no }}" class="form-control input-md" >
                        <span class="help-block">10 Digit Mobile No without +91 or 0</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="address">Address</label>
                    <div class="col-md-5">
                        <textarea class="form-control" id="address" name="address">{{ $member->address }}</textarea>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="pincode">Pincode</label>
                    <div class="col-md-5">
                        <input id="pincode" name="pincode" type="text" value="{{ $member->pincode }}" class="form-control input-md" >
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="city">City</label>
                    <div class="col-md-5">
                        <input id="city" name="city" type="text" value="{{ $member->city }}" class="form-control input-md" >
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="district">District</label>
                    <div class="col-md-5">
                        <input id="district" name="district" type="text" value="{{ $member->district }}" class="form-control input-md" >
                        <span class="help-block"></span>
                    </div>
                </div>
                <!-- Select Basic state -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="state">State</label>
                    <div class="col-md-5">
                        <select id="state" name="state" class="form-control">
                            <option value="">--select--</option>
                            <option value="Andhra Pradesh">Andhra Pradesh</option>
                            <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                            <option value="Assam">Assam</option>
                            <option value="Bihar">Bihar</option>
                            <option value="Chhattisgarh">Chhattisgarh</option>
                            <option value="Goa">Goa</option>
                            <option value="Gujarat">Gujarat</option>
                            <option value="Haryana">Haryana</option>
                            <option value="Himachal Pradesh">Himachal Pradesh</option>
                            <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                            <option value="Jharkhand">Jharkhand</option>
                            <option value="Karnataka">Karnataka</option>
                            <option value="Kerala">Kerala</option>
                            <option value="Madhya Pradesh">Madhya Pradesh</option>
                            <option value="Maharashtra">Maharashtra</option>
                            <option value="Manipur">Manipur</option>
                            <option value="Meghalaya">Meghalaya</option>
                            <option value="Mizoram">Mizoram</option>
                            <option value="Nagaland">Nagaland</option>
                            <option value="Odisha">Odisha</option>
                            <option value="Punjab">Punjab</option>
                            <option value="Rajasthan">Rajasthan</option>
                            <option value="Sikkim">Sikkim</option>
                            <option value="Tamil Nadu">Tamil Nadu</option>
                            <option value="Telangana">Telangana</option>
                            <option value="Tripura">Tripura</option>
                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                            <option value="Uttarakhand">Uttarakhand</option>
                            <option value="West Bengal">West Bengal</option>
                        </select>
                        <span class="help-block"></span>
                    </div>
                </div>
                <!-- Text input checkBox applied_pancard -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="pancard">Pan Card</label>
                    <div class="col-md-5">
                        <input id="pancard" name="pancard" type="text" value="{{ $member->pancard }}" class="form-control input-md">
                        <input type="checkbox" name="applied_pan" id="applied_pan" value="Yes"> Applied for Pan Card
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="nominee_name">Nominee Name</label>
                    <div class="col-md-5">
                        <input id="nominee_name" name="nominee_name" type="text" value="{{ $member->nominee_name }}" class="form-control input-md" >
                        <span class="help-block"></span>
                    </div>
                </div>
                <!-- Select input nominee_relation-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="nominee_relation">Nominee Relation</label>
                    <div class="col-md-5">
                        <select name="nominee_relation" id="nominee_relation" class="form-control">
                            <option value="">Select</option>
                            <option>Father</option>
                            <option>Mother</option>
                            <option>Brother</option>
                            <option>Sister</option>
                            <option>Husband</option>
                            <option>Wife</option>
                            <option>Son</option>
                            <option>Daughter</option>
                            <option>Friend</option>
                        </select>
                        <span class="help-block"></span>
                    </div>
                </div>
                <!-- Select Basic bank -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="bank">Bank</label>
                    <div class="col-md-5">
                        <select id="bank" name="bank" class="form-control">
                            <option value="">--select--</option>
                            <option>Allahabad Bank</option>
                            <option>Andhra Bank</option>
                            <option>Axis Bank</option>
                            <option>Bank of Bahrain and Kuwait</option>
                            <option>Bank of Baroda - Corporate Banking</option>
                            <option>Bank of Baroda - Retail Banking</option>
                            <option>Bank of India</option>
                            <option>Bank of Maharashtra</option>
                            <option>Canara Bank</option>
                            <option>Central Bank of India</option>
                            <option>City Union Bank</option>
                            <option>Corporation Bank</option>
                            <option>Deutsche Bank</option>
                            <option>Development Credit Bank</option>
                            <option>Dhanlaxmi Bank</option>
                            <option>Federal Bank</option>
                            <option>ICICI Bank</option>
                            <option>IDBI Bank</option>
                            <option>Indian Bank</option>
                            <option>Indian Overseas Bank</option>
                            <option>IndusInd Bank</option>
                            <option>ING Vysya Bank</option>
                            <option>Jammu and Kashmir Bank</option>
                            <option>Karnataka Bank Ltd</option>
                            <option>Karur Vysya Bank</option>
                            <option>Kotak Bank</option>
                            <option>Laxmi Vilas Bank</option>
                            <option>Oriental Bank of Commerce</option>
                            <option>Punjab National Bank - Corporate Banking</option>
                            <option>Punjab National Bank - Retail Banking</option>
                            <option>Punjab Sind Bank</option>
                            <option>Shamrao Vitthal Co-operative Bank</option>
                            <option>South Indian Bank</option>
                            <option>State Bank of Bikaner Jaipur</option>
                            <option>State Bank of Hyderabad</option>
                            <option>State Bank of India</option>
                            <option>State Bank of Mysore</option>
                            <option>State Bank of Patiala</option>
                            <option>State Bank of Travancore</option>
                            <option>Syndicate Bank</option>
                            <option>Tamilnad Mercantile Bank Ltd.</option>
                            <option>UCO Bank</option>
                            <option>Union Bank of India</option>
                            <option>United Bank of India</option>
                            <option>Vijaya Bank</option>
                            <option>Yes Bank Ltd</option>
                        </select>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="account_no">Account No</label>
                    <div class="col-md-5">
                        <input id="account_no" name="account_no" type="text" value="{{ $member->account_no }}" class="form-control input-md" >
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="ifsc">IFSC Code</label>
                    <div class="col-md-5">
                        <input id="ifsc" name="ifsc" type="text" value="{{ $member->ifsc }}" class="form-control input-md">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="branch">Branch</label>
                    <div class="col-md-5">
                        <input id="branch" name="branch" type="text" value="{{ $member->branch }}" class="form-control input-md">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="password">Password</label>
                    <div class="col-md-5">
                        <input id="password" name="password" type="text" value="{{ $member->password }}" class="form-control input-md">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="save"></label>
                    <div class="col-md-8">
                        <button id="save" name="save" class="btn btn-success"><span class="glyphicon glyphicon-floppy-save"></span> Save</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
@endsection

@section('scripts')
    <script>

        $(document).ready(function (){
            $("#bank").val('{{ $member->bank }}');
            $("#nominee_relation").val('{{ $member->nominee_relation }}');
            $("#state").val('{{ $member->state }}');
            $("#dob_d").val('{{ $member->dob_d }}');
            $("#dob_m").val('{{ $member->dob_m }}');
            $("#dob_y").val('{{ $member->dob_y }}');

            @if($member->applied_pan == "Yes")
                $("#applied_pan").click();
            @endif
        })

        $("#save").click(function (){
            var save_btn = $(this);
            save_btn.attr('disabled', '');
            var frm = $("#reg_form").serializeArray();
            $.ajax({
                url     : "{{ route('admin.member.edit', ['id'=>$member->id]) }}",
                type    : "POST",
                data    : frm
            }).done(function (res){
                $(".has-error").removeClass('has-error');
                $(".invalid-feedback").html('');

                if(res.status === 'error'){
                    $.each(res.error, function(i, v){
                        $("#"+i).parent().parent().addClass('has-error');
                        $("#"+i).parent().children("span.help-block").html(v).addClass('invalid-feedback');
                    });
                }else if(res.status === 'success'){
                    if(confirm('Member Updated. Go to members Page ?')){
                        window.location.href = '{{ route('admin.members') }}';
                    }
                }else{
                    alert("Something went wrong.");
                }
            }).always(function (){
                save_btn.removeAttr('disabled');
            }).fail(function (err){
                console.log("Error" + err);
            });
        });

        $("#applied_pan").on('change', function (){
            if($("#applied_pan:checked").val() !== undefined){
                $("#pancard").attr('disabled', '');
            }else{
                $("#pancard").removeAttr('disabled');
            }
        });
    </script>
@endsection