<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-6 footerleft ">
                <div class="logofooter"> Play Cards Well Pvt. Ltd.</div>

                <p><i class="glyphicon glyphicon-map-marker"></i> 30, Sneh Nagar,<br>Patel Nagar, Main Road, <br>Indore, Madhya Pradesh 452001</p>
                <p><i class="glyphicon glyphicon-earphone"></i> Phone (India) : +91 99819 42294</p>
                <p><i class="glyphicon glyphicon-envelope"></i> E-mail : info@playcardswell.com</p>

            </div>
            <div class="col-md-2 col-sm-6 paddingtop-bottom">
                <h6 class="heading7">LINKS</h6>
                <ul class="footer-ul">
                    <li><a href="#"> Home</a></li>
                    <li><a href="#"> About Us</a></li>
                    <li><a href="#"> Login</a></li>
                    <li><a href="#"> Contact Us</a></li>
                </ul>
            </div>
            <div class="col-md-3 col-sm-6 paddingtop-bottom">
                <h6 class="heading7">ACHIEVERS</h6>
                <div class="post">
                    <marquee behavior="scroll" scrollamount="3" direction="up" style="height: 130px;">
                        @foreach( \App\Account::where('title', 'like', 'Level%')->orderBy('id', 'desc')->limit(10)->get() as $level )
                            <p>{{ $level->member->name }} qualified for {{ \App\Http\Controllers\Controller::level($level->member->pv->level-1, 'name') }}<span>{{ \Carbon\Carbon::parse($level->created_at)->format('d F Y') }}</span></p>
                        @endforeach
                    </marquee>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 paddingtop-bottom">
                <div class="fb-page" data-href="https://www.facebook.com/facebook" data-tabs="timeline" data-height="300" data-small-header="false" style="margin-bottom:15px;" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                    <div class="fb-xfbml-parse-ignore">
                        <blockquote cite="https://www.facebook.com/facebook"><a href="https://www.facebook.com/facebook">Facebook</a></blockquote>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="copyright">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p>© {{ Date('Y') }} - All rights reserved PlayCardsWell</p>
            </div>
            <div class="col-md-6">
                <ul class="bottom_ul">
                    <li><a href="#">Login</a></li>
                    <li><a href="#">Contact us</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="copyright">
    <div class="container">
        <center>
            <h5 style="color: #ccc;">Developed by <a href="http://spantechnologies.in">SPAN Technologies</a></h5>
        </center>
    </div>
</div>