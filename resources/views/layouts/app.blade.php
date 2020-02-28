<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @if(Auth::user())
        <meta name="jwt-token" content="{{ Session::Get('JWT') }}">
    @endif
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="re-captcha-key" content="{{ config('captcha.site_key') }}" >
    <!-- Base URL -->
    <meta name="base-url" content="{{ URL::to('/') }}">
    <meta name="keywords" content="contrata internet, contratar internet, internet hogar,
    internet satelital, internet para hogares, internet wifi, internet banda ancha,
    internet para negocios, internet para empresas, internet empresas, internet fibra optica,
    internet en bogota, internet para pueblos, internetpara mi casa, internet pymes,
    internet business, internet radio, internet economico, internet rapido, el internet
    mas economico de colombia, colombia internet, internet barato, tigo, claro, net2phone,
    telefonia ip, telefonia movil, voz sobre ip, telefonos grandStream, internexa, 
    azteca comunicaciones, HughesNet, ETB, Voip, telefonia en la nube, central virtual">
    <title>{{ config('app.name', 'Contrata Internet') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/intercolombia.png') }}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/toastr/toastr.min.css') }}">

</head>
<body>
    <div id="app">

      @yield('content')

      @yield('javascript-layout')
      <!-- View Javascript -->
      @yield('javascript')

    </div>

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>

    <script type="text/javascript">
        var _smartsupp = _smartsupp || {};
        _smartsupp.key = 'f0832250b549bc639cc1f1f7a6148651460afe4d';
        window.smartsupp||(function(d) {
          var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
          s=d.getElementsByTagName('script')[0];c=d.createElement('script');
          c.type='text/javascript';c.charset='utf-8';c.async=true;
          c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
        })(document);
    </script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-151798596-4"></script>

    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-151798596-4');
    </script>

</body>
</html>
