<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Single Leg Multi-Level Marketing Website, HO: Beohari, MP">
    <meta name="author" content="Aaditya Tamrakar - SPAN Technologies">
    <title>Play Cards Well</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <link href="/dist/css/main.css" rel="stylesheet">
    @yield('styles')
</head>
<body>
@include('partials.site_nav')
@include('partials.notify')
@yield('content')
@include('partials.site_footer')
<script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="/plugins/iCheck/icheck.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>
    !function(){if(/IEMobile\/10\.0/.test(navigator.userAgent)){var e=document.createElement("style");e.appendChild(document.createTextNode("@-ms-viewport{width:auto!important}")),document.head.appendChild(e)}}();
</script>
@yield('scripts')
</body>
</html>
