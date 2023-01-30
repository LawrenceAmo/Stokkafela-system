<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Fadaeco') }}</title>
        <link rel="stylesheet" href="{{ asset('mdb/css/mdb.min.css') }}">
        <link rel="stylesheet" href="{{ asset('mdb/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('mdb/css/admin.layout.css') }}">
        <link rel="stylesheet" href="{{ asset('mdb/css/style.css') }}">
        <script src="{{ asset('mdb/js/vue.js') }}"></script>
        <script src="{{ asset('mdb/js/axios.js') }}"></script>
 
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
 
   <style>
      body {
                font-family: 'Nunito', sans-serif;
            }
    .top-navbar{
      position: fixed; 
      top: 0px;
      width: 100%;
      margin: 0px;
      z-index: 1;
      background-color: whitesmoke
    }
   </style>
    </head>
    <body>
      
      <nav id="navbar-scroll" class="  navbar navbar-expand-lg navbar-light top-navbar   " style="">
      <div class="container">
        <!-- Brand -->
        <a class="navbar-brand" href="/">
       
          <img
            alt="fadaeco"
                          height="35"
            src="{{ asset('fadaeco.png') }}"
            id="navbar-logo"
            class="animate fadeInLeft"
          />
        </a>
        <!-- Toggler -->
        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarCollapse"
          aria-controls="navbarCollapse"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Collapse -->
        <div class="collapse navbar-collapse  d-flex justify-content-end" id="navbarCollapse">
          <ul class="navbar-nav mt-4 mt-lg-0 ml-auto ">
            <li class="nav-item dropdown dropdown-animate" data-toggle="hover">
            
            </li>
            {{-- <li class="nav-item">
              <a class="nav-link" href="index.html#services">Services</a>
            </li>    <li class="nav-item">
              <a class="nav-link" href="index.html#ecommerce">Pricing</a>
            </li>
            <li class="nav-item  ">
              <a class="nav-link" href="contact.html">Contact</a>
            </li> --}}
            <!-- <li class="nav-item">
              <a class="nav-link" href="about.html">About Us</a>
            </li> -->
            
 @if (Route::has('login'))
                     @auth
                        <li class="nav-item"><a href="{{ url('/portal') }}" class=" nav-link">My Portal</a> </li>  
                    @else
                      <li class="nav-item    ">
                        <a href="{{ route('login') }}" class="  nav-link">Log in</a>
                      </li>  

                      <li class="nav-item"> 
                        <a href="{{ route('register') }}" class="nav-link">Register</a>
                      </li>  
                     @endauth
             @endif           
          </ul>
          
        </div>
      </div>
      </nav>
        <div class="  text-gray font-weight-normal antialiased">
            {{ $slot }}
        </div>
          <footer class="position-relative" id="footer-main pt-0">
      <div class="footer pt-lg-7 footer-dark bg-dark">
        <!-- SVG shape -->
  
        <!-- Footer -->
        <div class="container " style="color: aliceblue;">       
           <div class="row align-items-center justify-content-md-between pb-3">
            <div class="col-md-6">
              <div
                class="copyright text-sm font-weight-bold text-center text-md-left"
              >
                &copy; 2022
                <a
                  href="https://fadaeco.com"
                  class="font-weight-bold"
                  target="_blank"
                  >Stokkafela Systems</a
                >. All rights reserved
              </div>
            </div>
            <div class="col-md-6">
              <ul
                class="nav justify-content-center justify-content-md-end mt-3 mt-md-0"
              >
                <li class="nav-item">
                  <a
                    class="nav-link font-italic"
                    href="terms-and-conditions.html"
                  >
                    Terms &nbsp;and &nbsp;Conditions
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link font-italic" href="privacy-policy.html">
                    Privacy
                  </a>
                </li>
                <!-- <li class="nav-item">
                  <a class="nav-link" href="#"> Cookies </a>
                </li> -->
              </ul>
            </div>
          </div>
        </div>
      </div>
    </footer>
    </body>
</html>
