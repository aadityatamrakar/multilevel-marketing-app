@extends('app')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" />
@endsection

@section('content')
    <section class="text-center contact bg-dark-g">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h2 class="section-heading" style="color: white">Contact Us</h2>
                </div>
            </div>
        </div>
    </section>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <h3>Play Cards Well Pvt. Ltd.</h3>
                <p>Single Leg MLM Plan, No Left No Right.</p>
                <p><i class="glyphicon glyphicon-map-marker"></i> 30, Sneh Nagar,<br>Patel Nagar, Main Road, <br>Indore, Madhya Pradesh 452001</p>
                <p><i class="glyphicon glyphicon-earphone"></i> Phone (India) : <a href="tel: +919981942294">+91 99819 42294</a></p>
                <p><i class="glyphicon glyphicon-envelope"></i> E-mail : <a href="mailto:info@playcardswell.com">info@playcardswell.com</a></p>
            </div>
            <div class="col-md-4 hidden-xs hidden-sm">
                <img src="/img/contact.jpg" width="360px" alt="contact_image" />
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-xs-8 col-xs-offset-2">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                    <input id="global_filter" placeholder="Search PIN Point" type="text" class="form-control input-lg">
                </div>

            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <table id="pp_tbl" class="table table-striped table-responsive table-bordered">
                    <thead>
                    <tr>
                        <th>State</th>
                        <th>City</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Address</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(\App\PinPoint::all() as $p)
                        <tr>
                            <td>{{ $p->state }}</td>
                            <td>{{ $p->city }}</td>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->mobile }}</td>
                            <td>{{ $p->address }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function (){
            $("#pp_tbl").dataTable({
                paging: false,
                searching: false,
            });

            function filterGlobal () {
                $('#pp_tbl').DataTable().search(
                    $('#global_filter').val(), false, true
                ).draw();
            }

            $('input#global_filter').on( 'keyup click', function () {
                filterGlobal();
            } );
        })
    </script>
@endsection