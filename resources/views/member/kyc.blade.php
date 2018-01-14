@extends('template.member')

@section('content')
    <div class="container">
        @if($member->kyc !== 1)
            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data" id="frm">
                <fieldset>
                    <legend>KYC Documents</legend>
                    <!-- Multiple Radios (inline) -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="idproof">ID Proof Type</label>
                        <div class="col-md-8">
                            <label class="radio-inline" for="idproof-0">
                                <input type="radio" name="idproof" id="idproof-0" value="Adhaar" checked="checked">
                                Adhaar
                            </label>
                            <label class="radio-inline" for="idproof-1">
                                <input type="radio" name="idproof" id="idproof-1" value="Voter ID">
                                Voter ID
                            </label>
                            <label class="radio-inline" for="idproof-2">
                                <input type="radio" name="idproof" id="idproof-2" value="Driving License">
                                Driving License
                            </label>
                            <label class="radio-inline" for="idproof-3">
                                <input type="radio" name="idproof" id="idproof-3" value="Passport">
                                Passport
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="address_proof">ID Proof</label>
                        <div class="col-md-4">
                            <img src="/uploads/member/apf_{{ $member->id }}.jpg" height="200px" />
                            <input id="ap_front_data" name="ap_front_data" type="hidden">
                            <span>Front</span><input id="ap_front" name="ap_front" class="input-file" type="file" accept="image/*">
                        </div>
                        <div class="col-md-4">
                            <img src="/uploads/member/apb_{{ $member->id }}.jpg" height="200px" />
                            <input id="ap_back_data" name="ap_back_data" type="hidden">
                            <span>Back</span><input id="ap_back" name="ap_back" class="input-file" type="file" accept="image/*">
                        </div>
                        <div class="col-md-6 col-md-offset-4">
                            <span>Adhaar, Voter ID, Driving License, Passport</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="id_proof">Pancard</label>
                        <div class="col-md-4">
                            <img src="/uploads/member/ip_{{ $member->id }}.jpg" height="200px" />
                            <input id="pancard_data" name="pancard_data" type="hidden">
                            <input id="pancard" name="pancard" class="input-file" type="file" accept="image/*">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="cheque">Bank Account</label>
                        <div class="col-md-8">
                            <label class="radio-inline" for="bank_account-0">
                                <input type="radio" name="bank_account" id="bank_account-0" value="Passbook" checked="checked">
                                Passbook
                            </label>
                            <label class="radio-inline" for="bank_account-1">
                                <input type="radio" name="bank_account" id="bank_account-1" value="Cancel Cheque">
                                Cancel Cheque
                            </label>
                        </div>
                        <div class="col-md-6  col-md-offset-4">
                            <img src="/uploads/member/c_{{ $member->id }}.jpg" height="200px" />
                            <input id="cheque_data" name="cheque_data" type="hidden">
                            <input id="cheque" name="cheque" class="input-file" type="file" accept="image/*">
                        </div>
                        <div class="col-md-6 col-md-offset-4">
                            <span>Passbook, Cancel Cheque</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="save"></label>
                        <div class="col-md-4">
                            <button id="save" name="save" class="btn btn-success">Submit</button>
                            <span class="help-block"></span>
                        </div>
                    </div>
                </fieldset>
            </form>
        @else
            <br><br>
            <div class="row">
                <div class="col-md-2 col-md-offset-2">
                    <center><img src="/img/member/done.jpeg" /></center>
                    <h2 class="text-center">KYC Done.</h2>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="panel-title">Uploaded Documents</div>
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#homef" aria-controls="homef" role="tab" data-toggle="tab">ID Proof Front ({{ $member->id_proof }})</a></li>
                                <li role="presentation"><a href="#homeb" aria-controls="homeb" role="tab" data-toggle="tab">ID Proof Bank ({{ $member->id_proof }})</a></li>
                                <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Pancard</a></li>
                                <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Bank ({{ $member->bank_proof }})</a></li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="homef">
                                    <a href="/uploads/member/apf_{{ $member->id }}.jpg" target="_blank"><img src="/uploads/member/apf_{{ $member->id }}.jpg" width="100%" /></a>
                                    <br><a href="/uploads/member/apf_{{ $member->id }}.jpg" target="_blank">Open in new window</a>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="homeb">
                                    <a href="/uploads/member/apb_{{ $member->id }}.jpg" target="_blank"><img src="/uploads/member/apb_{{ $member->id }}.jpg" width="100%" /></a>
                                    <br><a href="/uploads/member/apb_{{ $member->id }}.jpg" target="_blank">Open in new window</a>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="profile">
                                    <a href="/uploads/member/ip_{{ $member->id }}.jpg" target="_blank"><img src="/uploads/member/ip_{{ $member->id }}.jpg" width="100%" /></a>
                                    <br><a href="/uploads/member/ap_{{ $member->id }}.jpg" target="_blank">Open in new window</a>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="messages">
                                    <a href="/uploads/member/c_{{ $member->id }}.jpg" target="_blank"><img src="/uploads/member/c_{{ $member->id }}.jpg" width="100%" /></a>
                                    <br><a href="/uploads/member/c_{{ $member->id }}.jpg" target="_blank">Open in new window</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endif
    </div>
@endsection

@section('scripts')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    console.log("Done");
                    $(input).parent().children('img').attr('src', e.target.result);
                    $(input).parent().children('input[type="hidden"]').val(e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $('input[type="file"]').on('change', function(){
            readURL(this);
        });


        $("#save").click(function (){
            var btn = $(this);
            var percent_show = btn.parent().children('.help-block');
            btn.attr('disabled', '');

            var formData = new FormData();
            formData.append('address_proof_front', $("#ap_front_data").val());
            formData.append('address_proof_back', $("#ap_back_data").val());
            formData.append('pancard', $("#pancard_data").val());
            formData.append('cheque', $("#cheque_data").val());

            formData.append('id_proof', $('[name="idproof"]:checked').val());
            formData.append('bank_proof', $('[name="bank_account"]:checked').val());

            $.ajax({
                url: "{{ route('member.kyc') }}",
                type: "POST",
                async: true,
                processData: false,
                contentType: false,
                data: formData,
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            percentComplete = parseInt(percentComplete * 100);
                            percent_show.text("Uploading: "+percentComplete + '%');
                        }
                    }, false);
                    return xhr;
                },
            }).done(function (e){
                if(e.status == 'done'){
                    alert("KYC Uploaded.");
                    window.location.href = "{{ route('member.dashboard') }}";
                }else if(e.status == 'error'){
                    alert('Error: '+e.error);
                }
            });
        })
    </script>

@endsection