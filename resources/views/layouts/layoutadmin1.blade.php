<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>@yield('title') - {{ ucfirst(config('app.name'))}} </title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/components.css">
  @yield('csshere')
</head>

<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
        </form>
        <ul class="navbar-nav navbar-right">
       
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="../assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->name }}</div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-title">Logged in</div>
            
              <a href="{{ route('profile.show') }}"  class="dropdown-item has-icon">
                <i class="fas fa-user"></i>
                {{ __('Profile') }}
            </a>
          
              <div class="dropdown-divider"></div>
              <form method="POST" action="{{ route('logout') }}">
                @csrf

            
                    <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger"
                    onclick="event.preventDefault();
                                this.closest('form').submit();">
                        <i class="fas fa-sign-out-alt">    
                        </i> Logout
                      </a>
            </form>
             
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">SISTEM ADMINISTRASI</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard') }}">SA</a>
          </div>
          <ul class="sidebar-menu">
              <li class="menu-header">Dashboard</li>
            
              <li class="nav-item dropdown">
                <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-home"></i><span>Beranda</span></a>
              </li>

@php
if((Auth::user()->tipeuser)=='admin'){
    @endphp

              <li class="menu-header">Mastering</li>
              <li class="nav-item dropdown">
                <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-calendar-alt"></i><span>Tahun Pelajaran</span></a>
              </li>
              <li class="nav-item dropdown">
                <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-school"></i><span>Kelas</span></a>
              </li>
              <li class="nav-item dropdown">
                <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-user-graduate"></i><span>Siswa</span></a>
              </li>
              <li class="nav-item dropdown">
                <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-building"></i><span>Pegawai</span></a>
              </li>
         
              {{-- <li class="active"><a class="nav-link" href="blank.html"><i class="far fa-square"></i> <span>Blank Page</span></a></li> --}}
             
              <li class="menu-header">Transaksi</li>

              <li class="nav-item dropdown">
                <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-hand-holding-usd"></i><span>Pemasukan</span></a>
              </li>

              <li class="nav-item dropdown">
                <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-file-invoice-dollar"></i><span>Pengeluaran</span></a>
              </li>

              <li class="nav-item dropdown">
                <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-fire"></i><span>Tagihan Atur</span></a>
              </li>

              <li class="nav-item dropdown">
                <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-graduation-cap"></i><span>Tagihan Siswa</span></a>
              </li>
             
            </ul>

            <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
              <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Documentation
              </a>
            </div>
            @php
    }elseif((Auth::user()->tipeuser)=='kepsek'){
        @endphp

        @php
    }elseif((Auth::user()->tipeuser)=='siswa'){
        @endphp

        @php
    }
        @endphp
        </aside>
      </div>

      <!-- Main Content -->
      <div class="main-content">


        <section class="section">
            @yield('container')
        </section>


      </div>
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2021, Template <div class="bullet"></div> Design By <a href="https://nauval.in/">Muhamad Nauval Azhar</a>
        </div>
        <div class="footer-right">
          2.3.0
        </div>
      </footer>
    </div>
  </div>

  @yield('jshere')
  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="../assets/js/stisla.js"></script>

  <!-- JS Libraies -->

  <!-- Template JS File -->
  <script src="../assets/js/scripts.js"></script>
  <script src="../assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
</body>
</html>
