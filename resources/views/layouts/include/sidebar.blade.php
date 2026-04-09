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

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          @php
            $isOperasionalActive = Request::routeIs('peternak*') || Request::routeIs('ternak*') || request()->is('mutasi*');
            $isSistemActive = Request::routeIs('verifikasi') || Request::routeIs('user') || Request::routeIs('panduan');
          @endphp
          
          <li class="nav-header" style="font-size: 0.75rem; text-transform: uppercase; color: #94a3b8; font-weight: 700; margin-top: 10px; padding-left: 1rem;">NAVIGATION</li>
          
          <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link {{ Request::routeIs('home') ? 'active':'' }}">
              <i class="nav-icon fas fa-th-large"></i>
              <p>Dashboard</p>
            </a>
          </li>

          <li class="nav-item {{ $isOperasionalActive ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ $isOperasionalActive ? 'active' : '' }}">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>
                Operasional
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="padding-left: 10px;">
              <li class="nav-item">
                <a href="{{ route('peternak') }}" class="nav-link {{ Request::routeIs('peternak*') ? 'active':'' }}">
                  <i class="fas fa-users nav-icon" style="font-size: 0.85rem;"></i>
                  <p>Data Peternak</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('ternak') }}" class="nav-link {{ Request::routeIs('ternak*') ? 'active':'' }}">
                  <i class="fas fa-paw nav-icon" style="font-size: 0.85rem;"></i>
                  <p>Data Ternak</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('mutasi/kelahiran') }}" class="nav-link {{ request()->is('mutasi/kelahiran*') ? 'active':'' }}">
                  <i class="fas fa-baby nav-icon" style="font-size: 0.85rem;"></i>
                  <p>Data Kelahiran</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('mutasi/kematian') }}" class="nav-link {{ request()->is('mutasi/kematian*') ? 'active':'' }}">
                  <i class="fas fa-skull nav-icon" style="font-size: 0.85rem;"></i>
                  <p>Data Kematian</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('mutasi/pemotongan') }}" class="nav-link {{ request()->is('mutasi/pemotongan*') ? 'active':'' }}">
                  <i class="fas fa-cut nav-icon" style="font-size: 0.85rem;"></i>
                  <p>Data Pemotongan</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item {{ $isSistemActive ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ $isSistemActive ? 'active' : '' }}">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Sistem
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="padding-left: 10px;">
              @if(Auth::user()->user_type == 'A' OR Auth::user()->user_type == 'B')
              <li class="nav-item">
                <a href="{{ route('verifikasi') }}" class="nav-link {{ Request::routeIs('verifikasi') ? 'active':'' }}">
                  <i class="fas fa-check-double nav-icon" style="font-size: 0.85rem;"></i>
                  <p>Verifikasi Data</p>
                </a>
              </li>
              @endif
              
              @if(Auth::user()->user_type == 'A')
              <li class="nav-item">
                <a href="{{ route('user') }}" class="nav-link {{ Request::routeIs('user') ? 'active':'' }}">
                  <i class="fas fa-user-cog nav-icon" style="font-size: 0.85rem;"></i>
                  <p>Manajemen Pengguna</p>
                </a>
              </li>
              @endif

              <li class="nav-item">
                <a href="{{ route('panduan') }}" class="nav-link {{ Request::routeIs('panduan') ? 'active':'' }}">
                  <i class="fas fa-book-open nav-icon" style="font-size: 0.85rem;"></i>
                  <p>Panduan / Bantuan</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item mt-2 pt-2" style="border-top: 1px solid rgba(255,255,255,0.1);">
            <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Logout</p>
            </a>
            <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>