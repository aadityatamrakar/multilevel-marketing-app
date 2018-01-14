@extends('template.admin_b')

@section('content')
    <div class="container">
        <div class="row" style="margin-top:20px">
            <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
                <form role="form" method="post" action="{{ route('fpassword') }}">
                    <fieldset>
                        <center>
                            <img src="/img/logow.png" width="100%" alt="PCW Logo White"/>
                        </center>
                        <hr>
                        <h3>Forget Password</h3>
                        <div class="form-group">
                            <input style="text-transform: uppercase;" value="{{ isset($_COOKIE['username'])?$_COOKIE['username']:'' }}" type="text" name="username" id="username" class="form-control input-lg" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <input value="" type="number" maxlength="10" name="mobile" id="mobile" class="form-control input-lg" placeholder="Registered Mobile">
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Get OTP in Mobile">
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
@endsection