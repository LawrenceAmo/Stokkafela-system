<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Stokkafela Systems') }}</title>
 
<link rel="stylesheet" href="{{ asset('mdb/css/mdb.min.css') }}">
<link rel="stylesheet" href="{{ asset('mdb/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('mdb/css/admin.layout.css') }}">
<link rel="stylesheet" href="{{ asset('mdb/css/style.css') }}">
<script src="{{ asset('mdb/js/vue.js') }}"></script>
<script src="{{ asset('mdb/js/axios.js') }}"></script>
 {{-- <script src="https://unpkg.com/vue@3"></script> --}}
 
        <!-- Fonts -->
        {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"> --}}
  
    </head>
    <body class="font-sans antialiased">
            <!-- Page Heading -->           
            <header>
      <!-- Sidebar -->
      <nav
        id="sidebarMenu"
        class="collapse d-lg-block sidebar shadow-2xl  collapse " style="z-index: 1;"
      >
        <div class="position-sticky ">
          <div class="list-group list-group-flush mx-3 mt-1 pt-1">
            <a href="{{route('portal')}}"
              class="list-group-item list-group-item-action py-2 ripple " 
              aria-current="true">
              <i class="fa fa-tachometer-alt fa-fw h6"></i><span>Dashboard</span>
            </a> 

              <a class="list-group-item list-group-item-action py-2 mb-0 ripple " data-toggle="collapse" href="#users_nav_btn" role="button" aria-expanded="false" aria-controls="users_nav_btn">
                <span> <i class="fa fa-users fa-fw "></i>  Users </span> <span class="float-right"> <i class="fa fa-angle-down    "></i> </span>
              </a>             
            <div class="collapse" id="users_nav_btn">
              <div class=" ml-3 border-left pl-2 ">
                <a href="{{route('profile')}}"
                  class="list-group-item list-group-item-action py-2 ripple border-right-0 border-left-0 border-top-0 "
                  aria-current="true">
                  <span>My Profile</span>
                </a>
                <a href="{{ route("staff")}}"
                  class="list-group-item list-group-item-action py-2 ripple border-right-0 border-left-0 border-top-0"
                  ><span>Staff</span></a>
              </div>
            </div>

            <a class="list-group-item list-group-item-action py-2 mb-0 ripple " data-toggle="collapse" href="#stores_nav_btn" role="button" aria-expanded="false" aria-controls="stores_nav_btn">
              <i class="fas fa-building fa-fw "></i>  Stores <span class="  float-right d-flex justify-content-between text-right  "> <i class="fa fa-angle-down      "></i> </span>
            </a>
            <div class="collapse" id="stores_nav_btn">
              <div class=" ml-3 border-left pl-2 ">

                <a href="{{ route("stores")}}"
                  class="list-group-item list-group-item-action py-2 ripple border-right-0 border-left-0 border-top-0"
                  ><span>Stores</span></a>
                <a href="{{ route("spaza_shops")}}"
                class="list-group-item list-group-item-action py-2 ripple border-right-0 border-left-0 border-top-0" 
                ><span>Spaza Shops</span></a> 
  
                <a href="{{ route("store_locations")}}"
                class="list-group-item list-group-item-action py-2 ripple border-right-0 border-left-0 border-top-0"
                ><span>Store Locations</span></a>

              </div>
            </div>
            
            <a href="{{route('stock_analysis', [0])}}"
            class="list-group-item list-group-item-action py-2 ripple "
            aria-current="true">
            <i class="fa fa-chart-pie fa-fw "></i><span>DOH Reports</span>
          </a>         
            <a href="{{ route("sales")}}"
              class="list-group-item list-group-item-action py-2 ripple">
              <i class="fa fa-chart-bar"></i>
              <span>Sales</span>
            </a>
            <a href="{{ route("shopping")}}"
              class="list-group-item list-group-item-action py-2 ripple">
              <i class="fa fa-shopping-cart"></i>
              <span>Shopping</span>
            </a>
            <a href="{{ route("maintanance")}}"
              class="list-group-item list-group-item-action py-2 ripple">
              <i class="fa fa-bars"></i>
              <span>Maintanance</span>
            </a>
             
            <a href="{{ route("debtors")}}"
              class="list-group-item list-group-item-action py-2 ripple"
              ><i class="fa fa-users fa-x2 "></i><span>Debtors</span></a>            
            <a href="{{ route("departments")}}"
              class="list-group-item list-group-item-action py-2 ripple">
              <i class="fa fa-bars "></i><span>Departments</span>
            </a> 
            <a href="{{ route("departments")}}"
              class="list-group-item list-group-item-action py-2 ripple">
              <i class="fa fa-file "></i>  <span>Documents(Files)</span>
            </a>     
            <form action="{{ route('logout') }}" method="POST"
               class="list-group-item  btn-outline-danger rounded font-weight-bold list-group-item-action py-2 ripple">
              @csrf
              <label for="logout" class="c-pointer">
                <i class="fas fa-door-open "></i><span>Log out</span>
              </label>
              <input type="submit" name="" id="logout" class="d-none" >
              </form
            >
          </div>
        </div>
      </nav>
      <!-- Sidebar -->
      <!-- Navbar -->
      <nav
        id="main-navbar"
        class="navbar navbar-expand-lg navbar-light p-0 bg-white fixed-top"
      >
        <!-- Container wrapper -->
        <div class="container-fluid">
          <!-- Toggle button -->
          <button
            class="navbar-toggler"
            type="button"
            data-mdb-toggle="collapse"
            data-mdb-target="#sidebarMenu"
            aria-controls="sidebarMenu"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <i class="fas fa-bars"></i>
          </button>

          <!-- Brand -->
          <a class="navbar-brand pl-3" href="{{route('portal')}}">
            <img
              src="{{ asset('fadaeco.png') }}"
              height="40"
              alt="Fadaeco"
              loading="lazy"
            /> 
          </a>
      
          <!-- Right links -->
          <ul class="navbar-nav ms-auto d-flex flex-row ">
            <!-- Icon -->
            

            <!-- Icon -->
            <li class="nav-item me-3 me-lg-0">
              <form action="{{ route('logout') }}" method="POST"
               class="nav-link hoverable rounded"
              >
              @csrf
              <label for="logout" class="c-pointer"><i class="fas fa-door-open"></i> Log out</label>
              <input type="submit" name="" id="logout" class="d-none" >
              </form
            >
               
            </li>
          </ul>
        </div>
        <!-- Container wrapper -->
      </nav>
      <!-- Navbar -->
    </header>

            <!-- Page Content -->
            <main class="    mt-5 pt-3   ">
                {{ $slot }}
            </main>
        {{-- </div> --}}
        {{-- All the js files --}}
<script>
</script>
         
        
    {{-- <script src="{{ asset('js/main.js') }}"></script> --}}
    <script src="{{ asset('mdb/js/jquery.min.js') }}"></script>
        <script src="{{ asset('mdb/js/popper.min.js') }}"></script>
    <script src="{{ asset('mdb/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('mdb/js/mdb.min.js') }}"></script>
    <script src="{{ asset('mdb/js/axios.js') }}"></script>

    {{-- <script src="{{ asset('mdb/js/bootstrap.bundle.min.js') }}"></script> --}}


        {{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> --}}
        {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.js"></script> --}}

        {{-- <script src="{{ asset('mdb/js/mdb.min.js') }}"></script> --}}
        
    </body>
</html>
 