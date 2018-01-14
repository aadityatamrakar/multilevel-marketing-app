@extends('app')

@section('content')
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img class="first-slide" src="/img/banner/b1.jpg" alt="First Banner">
                <div class="container">

                </div>
            </div>
            <div class="item">
                <img class="first-slide" src="/img/banner/b2.jpg" alt="Second Banner">

            </div>
            <div class="item">
                <img class="first-slide" src="/img/banner/b3.jpg" alt="Third Banner">
                <div class="container">

                </div>
            </div>
        </div>
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div><!-- /.carousel -->

    <section class="text-center contact">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h2 class="section-heading">Play Cards Well Pvt. Ltd.</h2>
                    <p>Play Cards Well Pvt. Ltd. is new marketing plan with single leg, its belonging from Indore M.P. Our motto is to provide quality products at reasonable prices to the consumers. We use medium of Direct selling to remove middle men and promotional costs and pass the saving to our customers as well as Direct sellers in form of incentives/commissions.</p>
                </div>
            </div>
        </div>
    </section>

    <div class="container marketing">
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

    @if(\App\News::all()->count() > 0)
        <div class="container">
            <div class="panel panel-info" style="padding: 0px;">
                <div class="panel-heading">
                    <div class="panel-title">News</div>
                </div>
                <div class="panel-body" style="padding: 0px 10px; margin: 0px;">
                    <marquee behavior="scroll" scrollamount="5" direction="left">
                        <p style="color:black; font-size: 20px; padding: 0px; margin: 0px;">
                            @foreach(\App\News::orderBy('id', 'desc')->get() as $index=>$news)
                                <span>{{ \Carbon\Carbon::parse($news->created_at)->format('d/m/Y') }}&nbsp;-&nbsp;{{ $news->body }}</span>&nbsp;&nbsp;|&nbsp;&nbsp;
                            @endforeach
                        </p>
                    </marquee>
                </div>
            </div>
        </div>
    @endif

@endsection