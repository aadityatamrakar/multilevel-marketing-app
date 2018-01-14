@extends('template.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-9">
                <h3>News</h3>
            </div>
            <div class="col-xs-3 pull-right" style="padding-top: 15px; text-align: right;">
                <button data-do="add" data-toggle="modal" data-target="#pin_point_modal" class="btn btn-sm btn-primary"><i class="glyphicon-plus glyphicon"></i> Add News</button>
            </div>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>News</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach(\App\News::all() as $index=>$p)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $p->body }}</td>
                    <td>
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
                        <h4 class="modal-title" id="myModalLabel">News</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" id="frm" method="post" action="" onsubmit="return false;">
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="body">News Content</label>
                                    <div class="col-md-5">
                                        <textarea class="form-control" id="body" name="body"></textarea>
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
        $("#save").click(function (){
            var btn = $(this);
            btn.attr('disabled', '');
            var frmData = $("#frm").serializeArray();
            $.ajax({
                url: "{{ route('admin.news') }}",
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
                    alert("News Added.");
                    $("#body").val('');
                    $("#pin_point_modal").modal('hide');
                }
                btn.removeAttr('disabled');
            }).fail(function (){
                btn.removeAttr('disabled');
            })
        });

        $('[data-toggle="delete"]').click(function (){
            var b = $(this);
            b.attr('disabled', '');
            var id = b.data('target');
            if(confirm("Confirm Delete ?")){
                $.ajax({
                    url: "{{ route('admin.news.delete') }}",
                    type: "POST",
                    data: {id: id}
                }).done(function (res){
                    if(res.status == 'done'){
                        alert("News Deleted.");
                        b.parent().parent().remove();
                    }
                }).fail(function (err){
                    if(err.status == 404){
                        alert("News Not Found.");
                        b.parent().parent().remove();
                    }
                    b.removeAttr('disabled');
                })
            }else b.removeAttr('disabled');
        });
    </script>
@endsection