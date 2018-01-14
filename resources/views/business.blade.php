@extends('app')

@section('styles')
    <link href="https://fonts.googleapis.com/css?family=Playball" rel="stylesheet">
@endsection

@section('content')
    <section class="text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h2 class="section-heading" style="color:#0c1a1e; font-size: 42px; font-weight: bold; letter-spacing: 2px; text-shadow: #ccc 1px 1px 1px;">Business Plan</h2>
                    <p style="font-family: 'Playball', cursive; color: #0c1a1e; font-size: 22px;">Single Leg Plan, No Left No Right</p>
                </div>
            </div>
        </div>
    </section>
    <br>
    <div class="container">

        <ul style="font-size: 18px;">
            <li>Free Registration</li>
            <li>Product Purchase Amount is Rs. 3000/- (PV)</li>
            <li>Direct Sponsor Income 300/-</li>
            <li>Payout Closing Weekly (Bank Withdrawal/PayTM/Pin-Generate)</li>
        </ul>

        <table class="table table-bordered table-striped" style="font-weight: bold; font-size: 15px;">
            <thead style="background-color: #0c1a1e; color:white;">
                <tr>
                    <th>S.NO</th>
                    <th>Level Name</th>
                    <th>Direct Referral</th>
                    <th>Downline</th>
                    <th>Downline PV</th>
                    <th>Income (In Rs.)</th>
                </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td>Area Manager</td>
                <td>1</td>
                <td>1 Manager</td>
                <td>50000</td>
                <td>500/-</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Junior Manager</td>
                <td>1</td>
                <td>1 Area Manager</td>
                <td>1 Lakh</td>
                <td>1000/-</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Team Manager</td>
                <td>1</td>
                <td>1 Junior Manager</td>
                <td>2.5 Lakh</td>
                <td>2500/-</td>
            </tr>

            <tr>
                <td>4</td>
                <td>Life Manager</td>
                <td>1</td>
                <td>1 Team Manager</td>
                <td>5 Lakh</td>
                <td>5000/-</td>
            </tr>
            <tr>
                <td>5</td>
                <td>National Manager</td>
                <td>1</td>
                <td>1 Life Manager</td>
                <td>10 Lakh</td>
                <td>10000/-</td>
            </tr>

            <tr>
                <td>6</td>
                <td>International Manager</td>
                <td>1</td>
                <td>-</td>
                <td>25 Lakh</td>
                <td>-</td>
            </tr>

            <tr>
                <td>7</td>
                <td>World Manager</td>
                <td>1</td>
                <td>-</td>
                <td>50 Lakh</td>
                <td>-</td>
            </tr>

            <tr>
                <td>8</td>
                <td>Global Manager</td>
                <td>1</td>
                <td>-</td>
                <td>1 CR.</td>
                <td>-</td>
            </tr>
            <tr>
                <td>9</td>
                <td>Double Manager</td>
                <td>1</td>
                <td>-</td>
                <td>2.5 CR.</td>
                <td>-</td>
            </tr>
            <tr>
                <td>10</td>
                <td>Triple Manager</td>
                <td>1</td>
                <td>-</td>
                <td>5 CR.</td>
                <td>-</td>
            </tr>
            <tr>
                <td>11</td>
                <td>Crown Manager</td>
                <td>1</td>
                <td>-</td>
                <td>10 CR.</td>
                <td>-</td>
            </tr>
            <tr>
                <td>12</td>
                <td>Royal Manager</td>
                <td>1</td>
                <td>-</td>
                <td>25 CR.</td>
                <td>-</td>
            </tr>
            </tbody>
        </table>
    </div>

@endsection