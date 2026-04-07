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
                            <h3 class="card-title">Tambah Peternak</h3>

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
                        <form action="{{ route('peternak.store') }}" method="POST">
                            {{csrf_field()}}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="nik">NIK</label>
                                            <input type="number" class="form-control" name="nik" id="nik" value="{{ old('nik') }}" placeholder="Enter ..." required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control" name="nama" id="nama" value="{{ old('nama') }}" placeholder="Enter ..." required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="tempat_lahir">Tempat Lahir</label>
                                            <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Enter ..." required>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="tanggal_lahir">Tanggal Lahir</label>
                                            <div class="input-group date">
                                                <input type="date" class="form-control" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                        <label for="jenis_kelamin">Jenis Kelamin</label>
                                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="1">Laki-laki</option>
                                            <option value="2">Perempuan</option>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="kab_kota">Kabupaten/Kota</label>
                                            @if(Auth::user()->user_type == "A")
                                                <select name="kab_kota" id="kab_kota" class="form-control" required>
                                                    <option value="">Pilih Kabupaten/Kota</option>
                                                    @foreach($kab_kota as $kk)
                                                    <option value="{{$kk->id}}">{{$kk->nama_kab_kota}}</option>
                                                    @endforeach
                                                </select>
                                            @elseif(Auth::user()->user_type == "B" or Auth::user()->user_type == "C")
                                                <select name="kab_kota" id="kab_kota" class="form-control" required>
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
                                                <select name="kecamatan" id="kecamatan" class="form-control" required>
                                                    <option value="">Pilih Kecamatan</option>
                                                </select>
                                            @elseif(Auth::user()->user_type == "B" or Auth::user()->user_type == "C")
                                                <select name="kecamatan" id="kecamatan" class="form-control" required>
                                                    <option value="">Pilih Kecamatan</option>
                                                    @foreach($kecamatan as $kc)
                                                    <option value="{{ $kc->id }}">{{ $kc->nama_kecamatan }}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="desa_kel">Desa/Kelurahan</label>
                                            <select name="desa_kel" id="desa_kel" class="form-control" required>
                                                <option value="">Pilih Desa/Kelurahan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea name="alamat" id="alamat" class="form-control" required>{{ old('alamat') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="hp">Nomor Hp</label>
                                    <input type="number" class="form-control" name="hp" id="hp" value="{{ old('hp') }}" placeholder="Hp" required>
                                </div>
                                <div class="form-group">
                                    <label for="pekerjaan">Pekerjaan</label>
                                    <select name="pekerjaan" id="pekerjaan" class="form-control" required>
                                        <option value="">Pilih Pekerjaan</option>
                                        <option value="1">ASN/TNI/POLRI</option>
                                        <option value="2">Peternak</option>
                                        <option value="3">Petani</option>
                                        <option value="4">Swasta</option>
                                        <option value="5">Wiraswasta</option>
                                        <option value="6">Pensiunan ASN/TNI/POLRI</option>
                                        <option value="7">Tidak Bekerja</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
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