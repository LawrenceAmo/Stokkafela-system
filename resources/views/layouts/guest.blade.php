<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Stokkafela')) | @yield('page-title', 'wholesale and Distribution')</title>
        <link rel="stylesheet" href="{{ asset('mdb/css/mdb.min.css') }}">
        <link rel="stylesheet" href="{{ asset('mdb/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('mdb/css/style.css') }}">
        <script src="{{ asset('mdb/js/vue.js') }}"></script>
        <script src="{{ asset('mdb/js/axios.js') }}"></script>
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"> 
   <style>
    /* @T.Rikhotso23 */
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
      <div class="container  ">
        <!-- Brand -->
        <a class="navbar-brand  " href="/">
          <img
            alt="fadaeco"
                          height="40"
            src="{{ asset('fadaeco.png') }}"
            id="navbar-logo"
            class="animate fadeInLeft"
          />
        </a>
        <!-- Toggler -->
        {{-- <button
          class="navbar-toggler d-none"
          type="button"
          data-toggle="collapse"
          data-target="#navbarCollapse"
          aria-controls="navbarCollapse"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button> --}}
        <!-- Collapse -->
        <div class="    d-flex justify-content-end" id="navbarCollapse">
          <ul class="navbar-nav   mt-lg-0 ml-auto ">
                      
            @if (Route::has('login'))
              @auth
                <li class="nav-item"><a href="{{ url('/portal') }}" class=" text-dark nav-link">My Portal</a> </li>  
            @else
                <li class="nav-item">
                  <a href="{{ route('login') }}" class=" text-dark font-weight-bold nav-link">Log in</a>
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
          <footer class="border w-100" style="position: reletive; bottom:0% !important;" id="footer-main pt-0">
      <div class="footer pt-lg-7 footer-dark bg-dark">
        <!-- SVG shape -->
  
        <!-- Footer -->
        <div class="container my-0 py-0" style="color: aliceblue;">       
           <div class="row align-items-center justify-content-md-between py-2">
            <div class="col-md-12">
              <div
                class="copyright text-sm font-weight-bold  py-auto text-center  "
              >
                &copy; <span class="" id="footerCurrentYear"></span>
                <a
                  href="https://stokkafela.com"
                  class="font-weight-bold text-light"
                  target="_blank"
                  >Stokkafela Cash & Carry (Pty) Ltd</a>. All rights reserved
              </div>
            </div>

          </div>
        </div>
      </div>
    </footer>
    <script>
      let date = new Date();
       document.getElementById('footerCurrentYear').innerHTML = date.getFullYear();
    </script>
        <script src="{{ asset('js/main.js') }}"></script>
        <script src="{{ asset('mdb/js/jquery.min.js') }}"></script>
        <script src="{{ asset('mdb/js/popper.min.js') }}"></script>
        <script src="{{ asset('mdb/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('mdb/js/mdb.min.js') }}"></script>
        <script src="{{ asset('mdb/js/axios.js') }}"></script>    
        <script src="{{ asset('mdb/js/bootstrap.bundle.min.js') }}"></script>
        
    </body>
</html>
