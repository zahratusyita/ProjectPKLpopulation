@extends('layouts.admin')

@section('content')
<div class="content content-wrapper">
    <div class="content-header">
        <section class="container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Pengguna</h3>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('user.update', $user->id) }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name">Nama</label>
                                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $user->name) }}" placeholder="Enter ..." required autofocus autocomplete="name">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $user->email) }}" placeholder="Enter ..." required autocomplete="email">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="user_type">Wewenang</label>
                                    <select name="user_type" id="user_type" class="form-control" required>
                                        <option value="">Pilih Wewenang</option>
                                        <option value="A" {{ $user->user_type == 'A' ? 'selected' : '' }}>Admin Provinsi</option>
                                        <option value="B" {{ $user->user_type == 'B' ? 'selected' : '' }}>Admin Kabupaten/Kota</option>
                                        <option value="C" {{ $user->user_type == 'C' ? 'selected' : '' }}>Admin Kecamatan</option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="kab_kota">Kabupaten/Kota</label>
                                            @if(Auth::user()->user_type == "A")
                                                <select name="kab_kota" id="kab_kota" class="form-control">
                                                    <option value="">Pilih Kabupaten/Kota</option>
                                                    @foreach($kab_kota as $kk)
                                                    <option value="{{$kk->id}}" {{ $user->kab_kota_id == $kk->id ? 'selected' : '' }}>{{$kk->nama_kab_kota}}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="kecamatan">Kecamatan</label>
                                            @if(Auth::user()->user_type == "A")
                                                <select name="kecamatan" id="kecamatan" class="form-control">
                                                    <option value="">Pilih Kecamatan</option>
                                                    @foreach($kecamatan as $kc)
                                                    <option value="{{$kc->id}}" {{ $user->kecamatan_id == $kc->id ? 'selected' : '' }}>{{$kc->nama_kecamatan}}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="password">Password Baru (Biarkan kosong jika tidak ingin mengubah)</label>
                                            <input type="password" class="form-control" name="password" id="password" placeholder="Enter baru ..." autocomplete="new-password">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="password_confirmation">Konfirmasi Password</label>
                                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi ..." autocomplete="new-password">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <a href="{{ route('user') }}" class="btn btn-secondary mr-2">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
