<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

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
        class="collapse d-lg-block sidebar shadow-2xl  collapse "
      >
        <div class="position-sticky ">
          <div class="list-group list-group-flush mx-3 mt-1 pt-1">
            <a
              href="{{route('portal')}}"
              class="list-group-item list-group-item-action py-2 ripple "
              aria-current="true"
            >
              <i class="fa fa-tachometer-alt fa-fw h6"></i><span>Dashboard</span>
            </a>
            <a
            href="{{route('profile')}}"
            class="list-group-item list-group-item-action py-2 ripple "
            aria-current="true"
          >
            <i class="fas fa-user-alt fa-fw "></i><span>My Profile</span>
          </a>
            <a
              href="{{ route("stores")}}"
              class="list-group-item list-group-item-action py-2 ripple"
            >
              <i class="fa fa-building"></i>
              <span>Stores</span>
            </a>     <a
              href="{{ route("products")}}"
              class="list-group-item list-group-item-action py-2 ripple"
            >
              <i class="fa fa-shopping-basket "></i>
              <span>Products</span>
            </a>
            <a
              href="{{ route("sales")}}"
              class="list-group-item list-group-item-action py-2 ripple"
            >
              <i class="fa fa-chart-bar"></i>
              <span>Sales</span>
            </a>
             <a
              href="{{ route("staff")}}"
              class="list-group-item list-group-item-action py-2 ripple"
              ><i class="fa fa-users fa-x2 "></i><span>Staff</span></a
            >
            <a
              href="{{ route("departments")}}"
              class="list-group-item list-group-item-action py-2 ripple"
            >
              <i class="fa fa-bars "></i><span>Departments</span>
            </a>
              <a
           href="#"
           class="list-group-item list-group-item-action py-2 ripple"
           ><i class="fa fa-graduation-cap fa-fw "></i><span>Jobs</span></a
          ><a
           href="#"
           class="list-group-item list-group-item-action py-2 ripple"
           ><i class="fas fa-globe fa-fw "></i 
          ><span>International</span></a
          >  
            <a
              href="get_help.html"
              class="list-group-item list-group-item-action py-2 ripple"
              ><i class="fas fa-info-circle "></i><span>Find Help</span></a
            >
            <form action="{{ route('logout') }}" method="POST"
               class="list-group-item  btn-outline-danger rounded font-weight-bold list-group-item-action py-2 ripple"
              >
              @csrf
              <label for="logout" class="c-pointer"><i class="fas fa-door-open "></i><span>Log out</span></label>
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
              height="35"
              alt="Fadaeco"
              loading="lazy"
            />
            {{-- <p class="h3 font-weight-bold"> 
              {{ "Stokkafela Tembisa"}} 
             </p> --}}
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
        </div>
        <script src="{{ asset('mdb/js/mdb.min.js') }}"></script>
        <script src="{{ asset('mdb/js/jquery.min.js') }}"></script>
        <script src="{{ asset('mdb/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('mdb/js/popper.min.js') }}"></script>
        <script src="{{ asset('mdb/js/bootstrap.bundle.min.js') }}"></script>
    </body>
</html>
