<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DPKH NTB | Populasi</title>
  <link rel="icon" href="{{ asset('assets/dist/img/logo_ntb.png') }}">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css')}}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('assets/plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assets/dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <!-- Global Green Theme Overrides -->
  <style>
    /* Ubah warna Sidebar sesuai kode kustom warna Navy Blue */
    .main-sidebar, .brand-link {
        background-color: #1e3a5f !important;
        border-right: 1px solid rgba(0,0,0,0.05) !important;
    }
    body:not(.layout-fixed) .main-sidebar {
        background-color: #1e3a5f !important;
    }

    /* Pastikan teks menu tetap putih dan terbaca jelas */
    .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link, 
    .brand-link .brand-text,
    .brand-link {
        color: #ffffff !important;
    }
    .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link i {
        color: rgba(255,255,255,0.9) !important;
    }
    .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link:hover {
        background-color: rgba(255,255,255,0.15) !important;
    }

    /* Menu item yang aktif: Hapus efek garis, gunakan sorotan transparan */
    .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
        background-color: rgba(255,255,255,0.2) !important;
        color: #ffffff !important;
        border: none !important;
        box-shadow: none !important;
        border-radius: 8px;
    }

    .content-wrapper {
        background-color: #f8fafc !important; /* Soft backdrop */
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">


  <!-- Navbar -->
  @include('layouts.include.navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('layouts.include.sidebar')

  <!-- Content Wrapper. Contains page content -->
  @yield('content')

  <!-- /.content-wrapper -->
  @include('layouts.include.footer')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script type="text/javascript" src="{{asset('assets/plugins/jquery/jquery.js')}}"></script>
<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Sparkline -->
<script src="{{asset('assets/plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('assets/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('assets/plugins/jquery-knob/jquery.knob.min.js')}}"></script>

<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('assets/dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="{{asset('assets/dist/js/demo.js')}}"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('assets/dist/js/pages/dashboard.js')}}"></script>

<script type="text/javascript">
  $(document).ready(function(){
    // $("#lokasi").hide();
    // ambil data kecamatan ketika memilih kabupaten/kota
    $('#kab_kota').on("change", function(){
      var id_kab_kota = $('#kab_kota').val();
      var data = "id="+id_kab_kota+"&data=kecamatan";

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        type: 'POST',
        url: "{{ route('daerah') }}",
        data: data,
        success: function(hasil){
          $("#kecamatan").html(hasil);
        }
      });
    });

    // ambil data desa/kelurahan ketika memilih kecamatan
    $('#kecamatan').on("change", function(){
      var id_kecamatan = $('#kecamatan').val();
      var data = "id="+id_kecamatan+"&data=desa_kel";

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        type: 'POST',
        url: "{{ route('daerah') }}",
        data: data,
        success: function(hasil){
          $("#desa_kel").html(hasil);
        }
      });
    });

    // ambil lokasi peternak
    $('#peternak').on("change", function(){
      var id_peternak = $('#peternak').val();
      var data = "id="+id_peternak+"&data=lokasi";
      console.log(id_peternak);
      console.log(data);

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        type: 'POST',
        url: "{{ route('daerah') }}",
        data: data,
        success: function(hasil){
          $("#lokasi").html(hasil);
          // $("#lokasi").show();
        }
      });
    });
  });
</script>
</body>
</html>
