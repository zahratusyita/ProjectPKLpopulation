<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto align-items-center pr-3">
      <!-- Modern User Profile Pill -->
      <li class="nav-item d-flex align-items-center bg-light rounded-pill px-3 py-1 shadow-sm border border-light" style="margin-top: 2px; margin-bottom: 2px;">
        <div class="d-flex flex-column text-right mr-3">
            <span class="font-weight-bold" style="color: #1e293b; font-size: 0.9rem; line-height: 1.2;">{{ Auth::user()->name }}</span>
            <span class="text-muted" style="font-size: 0.75rem; line-height: 1;">{{ Auth::user()->user_type == 'A' ? 'Administrator' : (Auth::user()->user_type == 'B' ? 'Verifikator' : 'Operator') }}</span>
        </div>
        <div class="image position-relative">
            <img src="{{asset('assets/dist/img/user2-160x160.jpg')}}" class="img-circle border border-white shadow-sm" style="width: 36px; height: 36px; object-fit: cover;" alt="User Image">
            <span class="position-absolute bg-success border border-white rounded-circle" style="width: 10px; height: 10px; bottom: 0; right: 0;"></span>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->