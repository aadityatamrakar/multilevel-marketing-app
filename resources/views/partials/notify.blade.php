@if(isset($_GET['info']))
    <div class="container">
        <div class="alert alert-{{ $_GET['type'] }}">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {!! $_GET['info'] !!}
        </div>
    </div>
@endif
