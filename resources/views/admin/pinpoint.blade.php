@extends('template.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-9">
                <h3>PIN Point</h3>
            </div>
            <div class="col-xs-3 pull-right" style="padding-top: 15px; text-align: right;">
                <button data-do="add" data-toggle="modal" data-target="#pin_point_modal" class="btn btn-sm btn-primary"><i class="glyphicon-plus glyphicon"></i> Add Point</button>
            </div>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>City</th>
                <th>State</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach(\App\PinPoint::all() as $index=>$p)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td data-id="{{ $p->id }}" data-content="name">{{ $p->name }}</td>
                    <td data-id="{{ $p->id }}" data-content="mobile">{{ $p->mobile }}</td>
                    <td data-id="{{ $p->id }}" data-content="city">{{ $p->city }}</td>
                    <td data-id="{{ $p->id }}" data-content="state">{{ $p->state }}</td>
                    <td>
                        <button data-toggle="modal" data-address="{{ $p->address }}" data-do="edit" data-target="#pin_point_modal" data-id="{{ $p->id }}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-pencil"></i> Edit</button>
                        <button data-toggle="delete" data-target="{{ $p->id }}" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i> Del</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>


        <div class="modal fade" id="pin_point_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">PIN Point</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" id="frm" method="post" action="" onsubmit="return false;">
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="name">Name</label>
                                    <div class="col-md-5">
                                        <input id="do" name="do" type="hidden">
                                        <input id="id" name="id" type="hidden">
                                        <input id="name" name="name" type="text" placeholder="" class="form-control input-md" required="">
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="mobile">Mobile</label>
                                    <div class="col-md-5">
                                        <input id="mobile" name="mobile" type="text" placeholder="" class="form-control input-md" required="">
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="address">Address</label>
                                    <div class="col-md-5">
                                        <textarea class="form-control" id="address" name="address"></textarea>
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="city">City</label>
                                    <div class="col-md-5">
                                        <input id="city" name="city" type="text" placeholder="" class="form-control input-md" required="">
                                        <span class="help-block"></span>
                                    </div>
                                </div>

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
                            </fieldset>
                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" id="save" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>

        $("#pin_point_modal").on('show.bs.modal', function (event){
            var button = $(event.relatedTarget);
            var dd = button.data('do');
            $("#do").val(dd);
            if(dd == 'edit'){
                var id = button.data('id');
                $("#id").val(id);
                $("#address").val(button.data('address'));
                $("#name").val($('[data-id="'+id+'"][data-content="name"]').html());
                $("#mobile").val($('[data-id="'+id+'"][data-content="mobile"]').html());
                $("#city").val($('[data-id="'+id+'"][data-content="city"]').html());
                $("#state").val($('[data-id="'+id+'"][data-content="state"]').html());
            }
        });

        $("#pin_point_modal").on('hide.bs.modal', function (event){
            if($("#do").val() == 'edit'){
                var id = $("#id").val();
                $('[data-id="'+id+'"][data-content="name"]').html($("#name").val());
                $('[data-id="'+id+'"][data-content="mobile"]').html($("#mobile").val());
                $('[data-id="'+id+'"][data-content="city"]').html($("#city").val());
                $('[data-id="'+id+'"][data-content="state"]').html($("#state").val());
            }

            $("#name").val("");$("#mobile").val("");
            $("#city").val("");$("#address").val("");
            $("#state").val("");
            $("#do").val("");$("#id").val("");
        });

        $("#save").click(function (){
            var btn = $(this);
            btn.attr('disabled', '');
            var frmData = $("#frm").serializeArray();
            $.ajax({
                url: "{{ route('admin.pinpoint') }}",
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
                }else if(res.status === 'success'){
                    alert("PIN Point Added.");
                    $("#pin_point_modal").modal('hide');
                }
                btn.removeAttr('disabled');
            }).fail(function (){
                btn.removeAttr('disabled');
            })
        })

        $('[data-toggle="delete"]').click(function (){
            var b = $(this);
            b.attr('disabled', '');
            var id = b.data('target');
            if(confirm("Confirm Delete ?")){
                $.ajax({
                    url: "{{ route('admin.pinpoint.delete') }}",
                    type: "POST",
                    data: {id: id}
                }).done(function (res){
                    if(res.status == 'done'){
                        alert("PIN Point Deleted.");
                        b.parent().parent().remove();
                    }
                }).fail(function (err){
                    if(err.status == 404){
                        alert("PIN Point Not Found.");
                        b.parent().parent().remove();
                    }
                    b.removeAttr('disabled');
                })
            }else b.removeAttr('disabled');
        })
    </script>
@endsection