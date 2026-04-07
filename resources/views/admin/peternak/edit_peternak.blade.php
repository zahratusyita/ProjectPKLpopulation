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
                            <h3 class="card-title">Update Peternak</h3>

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
                        <form action="{{ route('peternak.update', $peternak->id) }}" method="POST">
                            {{csrf_field()}}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="nik">NIK</label>
                                            <input type="text" class="form-control" name="nik" id="nik" value="{{ $peternak->nik }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control" name="nama" id="nama" value="{{ $peternak->nama }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="tempat_lahir">Tempat Lahir</label>
                                            <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" value="{{ $peternak->tempat_lahir }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="tanggal_lahir">Tanggal Lahir</label>
                                            <div class="input-group date">
                                                <input type="date" class="form-control" name="tanggal_lahir" value="{{ $peternak->tanggal_lahir }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                        <label for="jenis_kelamin">Jenis Kelamin</label>
                                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="1" @if($peternak->jenis_kelamin == 1) selected @endif>Laki-laki</option>
                                            <option value="2" @if($peternak->jenis_kelamin == 2) selected @endif>Perempuan</option>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="kab_kota">Kabupaten/Kota</label>
                                            <select name="kab_kota" id="kab_kota_" class="form-control" required>
                                                <option value="">Pilih Kabupaten/Kota</option>
                                                @foreach($kab_kota as $kk)
                                                <option value="{{$kk->id}}" @if($peternak->kab_kota_id == $kk->id) selected @endif>{{$kk->nama_kab_kota}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="kecamatan">Kecamatan</label>
                                            <select name="kecamatan" id="kecamatan_" class="form-control" required>
                                                <option value="">Pilih Kecamatan</option>
                                                @foreach($kecamatan as $kc)
                                                <option value="{{ $kc->id }}" @if($peternak->kecamatan_id == $kc->id) selected @endif>{{ $kc->nama_kecamatan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="desa_kel">Desa/Kelurahan</label>
                                            <select name="desa_kel" id="desa_kel_" class="form-control" required>
                                                <option value="">Pilih Desa/Kelurahan</option>
                                                @foreach($desa_kel as $dk)
                                                <option value="{{ $dk->id }}" @if($peternak->desa_kel_id == $dk->id) selected @endif>{{ $dk->nama_desa_kel }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea name="alamat" id="alamat" class="form-control" required>{{ $peternak->alamat }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="hp">Nomor Hp</label>
                                    <input type="number" class="form-control" name="hp" id="hp" placeholder="Hp" value="{{ $peternak->hp }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="pekerjaan">Pekerjaan</label>
                                    <select name="pekerjaan" id="pekerjaan" class="form-control" required>
                                        <option value="">Pilih Pekerjaan</option>
                                        <option value="1" @if($peternak->pekerjaan == 1) selected @endif>ASN/TNI/POLRI</option>
                                        <option value="2" @if($peternak->pekerjaan == 2) selected @endif>Peternak</option>
                                        <option value="3" @if($peternak->pekerjaan == 3) selected @endif>Petani</option>
                                        <option value="4" @if($peternak->pekerjaan == 4) selected @endif>Swasta</option>
                                        <option value="5" @if($peternak->pekerjaan == 5) selected @endif>Wiraswasta</option>
                                        <option value="6" @if($peternak->pekerjaan == 6) selected @endif>Pensiunan ASN/TNI/POLRI</option>
                                        <option value="7" @if($peternak->pekerjaan == 7) selected @endif>Tidak Bekerja</option>
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