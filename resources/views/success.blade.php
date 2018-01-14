@extends('app')

@section('content')
    <section class="text-center bg-dark-g">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h2 class="section-heading" style="color: white;">Registration Successful</h2>
                </div>
            </div>
        </div>
    </section>
    <hr>
    <div class="container">
        <div class="col-md-2 col-md-offset-2">
            <img width="100%" src="/img/check.gif" />
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title text-center" style="font-weight: bold;">Registration Details</div>
                </div>

                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <th>Member ID</th>
                        <td>PCW{{ isset($_GET['id'])?$_GET['id']:'' }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ isset($_GET['name'])?$_GET['name']:'' }}</td>
                    </tr>
                    <tr>
                        <th>Mobile</th>
                        <td>{{ isset($_GET['mobile'])?$_GET['mobile']:'' }}</td>
                    </tr>
                    <tr>
                        <th>Password</th>
                        <td>{{ isset($_GET['password'])?$_GET['password']:'' }} <a class="pull-right btn btn-sm btn-success" href="{{ route('login') }}"><i class="glyphicon-log-in glyphicon"></i> Login</a></td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <br><br><br>
@endsection