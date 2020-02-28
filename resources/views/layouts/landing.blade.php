@extends('layouts.app')

@section('content')

    <div class="content">
        <div class="ic-bg-main w-100 py-2 px-4" >
            <div class="container d-flex justify-content-end">
                <i class="fab fa-facebook-f i-c-main mx-2 text-white text-lg"></i>
                <i class="fab fa-twitter i-c-main mx-2 text-white text-lg"></i>
                <i class="fab fa-instagram i-c-main mx-2 text-white text-lg"></i>
            </div>
        </div>
        <nav class="main-header navbar-light navbar navbar-expand-md mx-auto py-3 px-1">
            <ul class="navbar-nav ml-3">
                <a class="nav-item" href="/">
                    <img class="ic-logo" src="{{ asset('images/logo.png') }}" alt="">
                </a>
            </ul>
            <a class="nav-link hidden-md nav-btn ml-auto mx-1 hidden-xl-xl hidden-xl hidden-lg hidden-xs"  href="https://contratainternet.speedtestcustom.com/">
                <i class="fas fa-tachometer-alt"></i>
            </a>
            <a class="nav-link hidden-md nav-btn mx-1 hidden-xl-xl hidden-xl hidden-lg" data-toggle="collapse"
              data-target="#responsive-menu">
                <i class="fas fa-bars"></i>
            </a>
            <div id="responsive-menu" class="navbar-collapse collapse ml-auto mr-0">
                <ul class="navbar-nav ml-auto mr-x3 ">
                    <li class="nav-item">
                        <a class="nav-link nav-item-border {{Route::current()->uri=='/'?'active':''}}" href="/">
                            <h6 class="ic-main font-weight-bold">
                                Inicio
                            </h6>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-item-border {{strpos(Route::current()->uri,'nosotros')>-1?'active':''}}" href="/nosotros">
                            <h6 class="ic-main font-weight-bold">
                                Nosotros
                            </h6>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-item-border {{strpos(Route::current()->uri,'blog')>-1?'active':''}}" href="/blog">
                            <h6 class="ic-main font-weight-bold">
                                Blog
                            </h6>
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link nav-item-border {{strpos(Route::current()->uri,'blog')>-1?'active':''}}" href="/blog">
                            <h6 class="ic-main font-weight-bold">
                                Blog
                            </h6>
                        </a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link nav-item-border {{strpos(Route::current()->uri,'contacto')>-1?'active':''}}" href="/contacto">
                            <h6 class="ic-main font-weight-bold">
                                Contacto
                            </h6>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-item-border" href="https://contratainternet.speedtestcustom.com/">
                            <h6 class="ic-main font-weight-bold">
                                Prueba de Velocidad
                            </h6>
                        </a>
                    </li>
                </ul>
              </div>

        </nav>

        @yield('content-page')

        <div class="footer-bg">
          <div class="d-flex flex-column align-items-center">
            <div class="mt-3">
              <img src="{{asset('images/logo-gris.png')}}" class="footer-img">
            </div>
            <div class="d-flex w-100 footer-links flex-wrap justify-content-bewtween">
              <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 my-2 footer-link-border">
                <h5 class="footer-title-color font-weight-bold">SERVICIOS DISPONIBLES</h5>
                <ul class="footer-list p-2">
                  <li>-internet satelital
                  </li>

                  <li>-Internet
                  </li>

                  <li>-Telefonia ip
                  </li>

                  <li>-MPLS
                  </li>

                  <li>-Television
                  </li>

                </ul>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 footer-link-border my-2">
                <h5 class="footer-title-color font-weight-bold">MAPA DE SITIO</h5>
                <ul class="footer-list p-2">
                  <a href="/"><li>-Inicio</li></a>
                  <a href="/nosotros"><li>-Nosotros</li></a>
                  <a href="/contacto"><li>-Contacto</li></a>
                  <a href="https://contratainternet.speedtestcustom.com/"><li>-Prueba de Velocidad</li></a>
                </ul>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 footer-link-border my-2">
                <h5 class="footer-title-color font-weight-bold">PONTE EN CONTACTO</h5>
                <ul class="footer-list p-2">
                  <li>-Correo Electrónico: contacto@contratainternet.co</li>
                  <li>-PBX: +57 (1) 7868510</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="d-flex w-100 justify-content-center align-items-center footer-footer">
          <span class="footer-title-color">Derechos Reservados 2020 - Desarrollado por <a href="https://portafolio.nextscale.net">NextScale®</a></span>
        </div>

        <div class="whatsapp">
            <a target="_blank"href="https://api.whatsapp.com/send?phone=573212120281&text=hola, me gustaria saber de los planes"> <img src="{{asset('/images/whatsapp.png')}}" width="67" height="67"> </a>
        </div>
  </div>

@stop
