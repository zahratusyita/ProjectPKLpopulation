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
                            <h3 class="card-title">Tambah Pengguna</h3>

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
                        <form action="{{ route('user.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name">Nama</label>
                                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" placeholder="Enter ..." required autofocus autocomplete="name">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" placeholder="Enter ..." required autofocus autocomplete="name">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="user_type">Wewenang</label>
                                    <select name="user_type" id="user_type" class="form-control" required>
                                        <option value="">Pilih Wewenang</option>
                                        <option value="A">Admin Provinsi</option>
                                        <option value="B">Admin Kabupaten/Kota</option>
                                        <option value="C">Admin Kecamatan</option>
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
                                                    <option value="{{$kk->id}}">{{$kk->nama_kab_kota}}</option>
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
                                                </select>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" name="password" id="password" placeholder="Enter ..." required autocomplete="new-password">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="password_confirmation">Konfirmasi Password</label>
                                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Enter ..." required autocomplete="new-password">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            <!-- <div class="flex items-center justify-end mt-4">
                                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                                    {{ __('Already registered?') }}
                                </a>

                                <x-button class="ms-4">
                                    {{ __('Register') }}
                                </x-button>
                            </div> -->
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