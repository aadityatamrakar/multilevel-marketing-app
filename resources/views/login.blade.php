@extends('template.admin_b')

@section('content')
    <div class="container">
        <div class="row" style="margin-top:20px">
            <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
                <form role="form" method="post" action="{{ route('login') }}">
                    <fieldset>
                        <center>
                            <img src="/img/logow.png" width="100%" alt="PCW Logo White"/>
                        </center>
                        <hr>
                        <div class="form-group">
                            <input style="text-transform: uppercase;" value="{{ isset($_COOKIE['username'])?$_COOKIE['username']:'' }}" type="text" name="username" id="username" class="form-control input-lg" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password">
                        </div>
                        <span class="button-checkbox">
					        <input type="checkbox" name="remember_me" id="remember_me" checked="checked" class="hidden">
					    </span>
                        <a href="{{ route('fpassword') }}" class="btn btn-link pull-right">Forgot Password?</a>

                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Sign In">
                            </div>
                        </div>
                    </fieldset>
                </form>
                <center><img width="100%" src="/img/login.jpg" alt="Login Image" /></center>
            </div>
        </div>
    </div>
@endsection