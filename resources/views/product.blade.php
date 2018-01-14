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
                    <h2 class="section-heading">Product</h2>
                    <img src="/img/product.jpg" width="500px" class="img-responsive img-thumbnail" />
                    <h3>Suit Length</h3>
                </div>
            </div>
        </div>
    </section>
@endsection