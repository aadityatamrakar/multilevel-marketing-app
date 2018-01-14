<nav class="navbar navbar-inverse" style="border-radius: 0px;">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#membernav" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="{{ route("member.dashboard") }}"><img src="/img/logo.png" width="350px" /></a>
        </div>

        <div class="collapse navbar-collapse" style="margin-top: 15px; font-size: 15px;" id="membernav">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ route('member.dashboard') }}">Home <span class="sr-only">(current)</span></a></li>
                <li><a target="_blank" href="{{ route('register') }}">New Registration</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Account <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('member.account.statement') }}">Statement</a></li>
                        <li><a href="{{ route('member.account.payout') }}">Payout (Day wise)</a></li>
                        <li><a href="{{ route('member.account.fundtransfer') }}">Fund Transfer</a></li>
                        <li><a href="{{ route('member.account.withdraw') }}">Withdraw Funds</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Downline <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('member.list.direct') }}">Direct Team</a></li>
                        <li><a href="{{ route('member.list.self') }}">Self Team</a></li>
                        <li><a href="{{ route('member.list.all') }}">All Team</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">PIN Management <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('member.epin.details') }}">E-PIN Details</a></li>
                        <li><a href="{{ route('member.epin.generate') }}">PIN Generate</a></li>
                        <li><a href="{{ route('member.epin.transfer') }}">PIN Transfer</a></li>
                        <li><a href="{{ route('member.epin.topup') }}">Package Top-up</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Profile <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('member.kyc') }}">KYC</a></li>
                        <li><a href="{{ route('member.profile') }}">Update</a></li>
                        <li><a href="{{ route('member.setting') }}">Change Password</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('member.logout') }}">Logout</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>