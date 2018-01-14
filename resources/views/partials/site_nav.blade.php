<nav class="navbar navbar-inverse" style="border-radius: 0px; margin-bottom: 0px;">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sitenav" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a style="color: white;" href="{{ route("home") }}"><img src="/img/logo.png" style="width: 100%; max-width:350px;" /></a>
        </div>

        <div class="collapse navbar-collapse mynav" id="sitenav" style="margin-top: 15px; color: white; font-size: 18px;">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ route('home') }}">Home <span class="sr-only">(current)</span></a></li>
                <li><a href="{{ route('about_us') }}">About Us</a></li>
                <li><a href="{{ route('product') }}">Product</a></li>
                <li><a href="{{ route('business_plan') }}">Business Plan</a></li>
                <li><a href="{{ route('contact') }}">Contact Us</a></li>
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}">Register</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>