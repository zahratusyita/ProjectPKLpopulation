
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Rekapitulasi | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assets/dist/css/adminlte.min.css')}}">
  <!-- <style type="text/css">
    body{
      background-image: url(<?php // echo base_url('assets/dist/img/sapi.jpg'); ?>);
      background-color: #cccccc;
      background-size: cover;
    }
  </style> -->
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
    <h5>Selamat Datang, {{ Auth::user()->name }}!</h5>  
    <h6>Pilih Tahun Data</h6>
    </div>

    <div class="card-body">
      <form action="{{ route('tahun-data-store') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <select class="form-control" name="tahun" id="tahun" required>
                <option value="">Pilih Tahun</option>
                @for($t=2025; $t<2027; $t++)
                    <option value="{{ $t }}">{{ $t }}</option>
                @endfor
            </select>
        </div>
        <div class="form-group">
          <button type="submit" class="form-control btn btn-primary">Submit</button>
        </div>
      </form>

      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <div class="form-group">
          <button type="submit" class="form-control btn btn-danger"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </div>
      </form>
      <!-- /.social-auth-links -->
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('assets/dist/js/adminlte.min.js')}}"></script>
</body>
</html>