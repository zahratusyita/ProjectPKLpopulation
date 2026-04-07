<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link d-flex">
      <div class="image">
        <img src="{{asset('assets/dist/img/logo_ntb.png')}}" alt="Logo NTB" class="brand-image img-circle elevation-3" style="opacity: .8">
      </div>
      <div class="info">
        <span class="brand-text font-weight-light"><small>Dinas PKH Provinsi NTB</small></span>
      </div>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('assets/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><small>{{ Auth::user()->name }}</small></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link {{ Request::routeIs('home') ? 'active':'' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('peternak') }}" class="nav-link {{ Request::routeIs('peternak') || Request::routeIs('peternak.*') ? 'active':'' }}">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Peternak
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('ternak') }}" class="nav-link {{ Request::routeIs('ternak') || Request::routeIs('ternak.*') ? 'active':'' }}">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Ternak
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('mutasi/kelahiran') }}" class="nav-link {{ request()->is('mutasi/kelahiran*') ? 'active':'' }}">
              <i class="nav-icon fas fa-baby"></i>
              <p>Kelahiran</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('mutasi/kematian') }}" class="nav-link {{ request()->is('mutasi/kematian*') ? 'active':'' }}">
              <i class="nav-icon fas fa-skull"></i>
              <p>Kematian</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('mutasi/pemotongan') }}" class="nav-link {{ request()->is('mutasi/pemotongan*') ? 'active':'' }}">
              <i class="nav-icon fas fa-cut"></i>
              <p>Pemotongan</p>
            </a>
          </li>
          @if(Auth::user()->user_type == 'A' OR Auth::user()->user_type == 'B')
          <li class="nav-item">
            <a href="{{ route('verifikasi') }}" class="nav-link {{ Request::routeIs('verifikasi') ? 'active':'' }}">
              <i class="nav-icon fas fa-check-circle"></i>
              <p>
                Verifikasi
              </p>
            </a>
          </li>
          @endif
          @if(Auth::user()->user_type == 'A')
          <li class="nav-item">
            <a href="{{ route('user') }}" class="nav-link {{ Request::routeIs('user') ? 'active':'' }}">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Akun User
              </p>
            </a>
          </li>
          @endif
          <li class="nav-item">
            <a href="{{ route('panduan') }}" class="nav-link {{ Request::routeIs('panduan') ? 'active':'' }}">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Panduan
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>