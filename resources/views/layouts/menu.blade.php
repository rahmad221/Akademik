@include('layouts.app')
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-flex align-items-center">
                <a href="{{ url('/version') }}" target="_blank" class="text-dark" style="font-size: 14px;">Versi 1.0.0</a>
              </li>
    </ul>
    
    <ul class="navbar-nav ml-auto">
      
    <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true" style="color: black;">
                        <i class="fas fa-user-circle"></i> &nbsp Hai , {{Auth::user()->name}} &nbsp <i class="fas fa-chevron-down"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
    <div class="dropdown-divider"></div>
    <a href="{{url('Profile')}}" class="dropdown-item">
        <i class="fas fa-cog mr-2"></i> Profile
    </a>
    <a href="#" target="_blank" class="dropdown-item">
        <i class="fa fa-question-circle mr-2"></i> Bantuan
    </a>
    <div class="dropdown-divider"></div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="dropdown-item" style="border: none; background: none; width: 100%; text-align: inherit;">
            <i class="fas fa-sign-out-alt mr-2"></i> Keluar
        </button>
    </form>

    </div>
                </li>
            </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{url('assets/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">DIS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{url('assets/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview">
            <a href="{{route('dashboard')}}" class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item {{ request()->is('master*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('master*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-database"></i>
              <p>
                Master Data
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            @permission('index_pengguna')
            <li class="nav-item">
                <a href="{{route('master.roles.index')}}" class="nav-link {{ request()->is('master/roles*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Role</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('master.users')}}" class="nav-link {{ request()->is('master/users*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Pengguna</p>
                </a>
              </li>
              @endpermission
              @permission('index_siswa')
              <li class="nav-item">
                <a href="{{route('master.siswa.index')}}" class="nav-link {{ request()->is('master/siswa*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Siswa</p>
                </a>
              </li>
              @endpermission
              @permission('index_guru')
              <li class="nav-item">
                <a href="{{route('master.guru.index')}}" class="nav-link {{ request()->is('master/guru*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Guru</p>
                </a>
              </li>
              @endpermission
              @permission('index_guru')
              <li class="nav-item">
              <a href="{{route('master.kelas.index')}}" class="nav-link {{ request()->is('master/kelas*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Kelas</p>
                </a>
              </li>
              @endpermission
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pembayaran</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview {{ request()->is('keuangan*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('keuangan*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Keuangan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link {{ request()->is('keuangan/spp*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Spp</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengeluaran</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tree"></i>
              <p>
                Report
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Nilai</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Raport</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link {{ request()->is('notifikasi*') ? 'active' : '' }}">
              <i class="nav-icon fa fa-bell"></i>
              <p>
                Notifikasi
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    @yield('content')

    </div>
  <!-- /.content-wrapper -->


  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>. &copy; 2025 <a href="https://cyberdeveloper.my.id/">cyberdeveloper</a>.</strong>
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{url('assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{url('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url('assets/dist/js/adminlte.js')}}"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Toastr -->
<script src="{{url('assets/plugins/toastr/toastr.min.js')}}"></script>
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
</script>
@yield('script')
</body>
</html>