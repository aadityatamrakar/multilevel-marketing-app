<nav class="navbar navbar-inverse" style="border-radius: 0px; margin-bottom: 0px;">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#adminnav" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="{{ route("admin.dashboard") }}"><img src="/img/logo.png" width="350px" /></a>
        </div>

        <div class="collapse navbar-collapse" style="margin-top: 15px; font-size: 15px;" id="adminnav">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ route('admin.dashboard') }}">Dashboard <span class="sr-only">(current)</span></a></li>
                <li><a href="{{ route('admin.epin') }}">E-PIN</a></li>
                <li><a href="{{ route('admin.members') }}">Members</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Payment <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#" data-href="{{ route('admin.daily_closing') }}" onclick="if(confirm('Confirm Daily Closing?')){ window.location=this.dataset.href; }">Daily Closing</a></li>
                        <li><a href="#" data-href="{{ route('admin.level') }}" onclick="if(confirm('Confirm Weekly Closing?')){ window.location=this.dataset.href; }">Weekly Closing</a></li>
                        <li><a href="{{ route('admin.payment') }}">Wallet Payment</a></li>
                        <li><a href="{{ route('admin.withdraw') }}">Withdraw</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Reports <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('admin.report_epin') }}">E-PIN Summary</a></li>
                        <li><a href="{{ route('admin.report_reg') }}">ID Registrations</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Wallet <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('admin.wallet.transfer') }}">M-M Transfer</a></li>
                        <li><a href="{{ route('admin.wallet.adjustment') }}">Adjustments</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Other <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('admin.pinpoint') }}">PIN Point</a></li>
                        <li><a href="{{ route('admin.news') }}">News</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Setting <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('admin.change_password') }}">Change Password</a></li>
                        <li><a href="{{ route('admin.logout') }}">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<br>