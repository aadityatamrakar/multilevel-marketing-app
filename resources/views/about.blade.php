@extends('app')

@section('content')
    <section class="text-center contact">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h2 class="section-heading">About.</h2>
                </div>
            </div>
        </div>
    </section>

    <div class="container marketing">

        <!-- Three columns of text below the carousel -->
        <div class="row">
            <div class="col-lg-4">
                <img class="img-circle" src="/img/vision.png" alt="Generic placeholder image" width="140" height="140">
                <h2>Vision</h2>
                <p>To make a team of Marketing Leaders. We are a young, energetic and dynamic team with keen enthusiasm and desire to learn and grow. We decided to teach our associates about finding real solution to the problems.</p>
            </div><!-- /.col-lg-4 -->
            <div class="col-lg-4">
                <img class="img-circle" src="/img/success_key.jpg" alt="Generic placeholder image" width="140" height="140">
                <h2>Mission</h2>
                <p>To make a team of Marketing Leaders. We are a young, energetic and dynamic team with keen enthusiasm and desire to learn and grow. We decided to teach our associates about finding real solution to the problems.</p>
            </div><!-- /.col-lg-4 -->
            <div class="col-lg-4">
                <img class="img-circle" src="/img/business_plan.jpg" alt="Generic placeholder image" width="140" height="140">
                <h2>Business Plan</h2>
                <p>New and improved Business Marketing plan with good rewards. Our business plan is simple and easy to complete. We are dedicated with our associates and Managers to sell.</p>
            </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->
    </div>


    <div class="container">
        <div class="panel panel-info" style="padding: 0px;">
            <div class="panel-heading">
                <div class="panel-title">News</div>
            </div>
            <div class="panel-body" style="padding: 0px 10px; margin: 0px;">
                <marquee behavior="scroll" scrollamount="5" direction="left">
                    <p style="color:black; font-size: 20px; padding: 0px; margin: 0px;">This is some news, This is some news This is some news This is some news This is some news This is some news</p>
                </marquee>

            </div>
        </div>
    </div>

@endsection