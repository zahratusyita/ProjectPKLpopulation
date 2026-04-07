@extends('layouts.admin')

@section('content')
<?php
    $no = 1;
?>
<div class="content content-wrapper">
    <div class="content-header">
        <section class="container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <!-- <div class="row"> -->
                                    <!-- <div class="col-md-4"> -->
                                    <div>
                                        <h3 class="card-title">Histori Verifikasi Data</h3>
                                    </div>
                                <!-- </div> -->
                            </div>
                            <!-- <div class="col-md container-fluid"> -->
                            <div class="card-header">
                                <form class="row" action="{{ route('verifikasi.search') }}" method="GET">
                                    {{ csrf_field() }}
                                    <!-- <div class="col-md">
                                        <select name="tahun" id="tahun" class="form-control">
                                            <option value="">Pilih Tahun</option>
                                            @for($t=2025; $t<2027; $t++)
                                            <option value="{{ $t }}">{{ $t }}</option>
                                            @endfor
                                        </select>
                                    </div> -->
                                    <div class="col-md">
                                        <!-- <label for="kab_kota">Kabupaten/Kota</label> -->
                                        @if(Auth::user()->user_type == "A")
                                            <select name="kab_kota" id="kab_kota" class="form-control">
                                                <option value="">Pilih Kabupaten/Kota</option>
                                                @foreach($kab_kota as $kk)
                                                <option value="{{$kk->id}}">{{$kk->nama_kab_kota}}</option>
                                                @endforeach
                                            </select>
                                        @elseif(Auth::user()->user_type == "B" or Auth::user()->user_type == "C")
                                            <select name="kab_kota" id="kab_kota" class="form-control">
                                                @foreach($kab_kota as $kk)
                                                <option value="{{$kk->id}}">{{$kk->nama_kab_kota}}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                    <div class="col-md">
                                        <!-- <label for="kecamatan">Kecamatan</label> -->
                                        @if(Auth::user()->user_type == "A")
                                            <select name="kecamatan" id="kecamatan" class="form-control">
                                                <option value="">Pilih Kecamatan</option>
                                            </select>
                                        @elseif(Auth::user()->user_type == "B" or Auth::user()->user_type == "C")
                                            <select name="kecamatan" id="kecamatan" class="form-control">
                                                <option value="">Pilih Kecamatan</option>
                                                @foreach($kecamatan as $kc)
                                                <option value="{{ $kc->id }}">{{ $kc->nama_kecamatan }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                    <div class="col-md">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Tahun</th>
                                        @if(Auth::user()->user_type == "A")
                                        <th>Kabupaten/Kota</th>
                                        @elseif(Auth::user()->user_type == "B")
                                        <th>Kecamatan</th>
                                        @endif
                                        <th>Status Pengajuan</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Status Verifikasi</th>
                                        <th>Tanggal Verifikasi</th>
                                        @if(Auth::user()->user_type == "A" OR Auth::user()->user_type == "B")
                                            <th>Aksi</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($verifikasi as $v)
                                            @if($v == '')
                                                <!-- <tr><td><h3>Tidak ada data</h3></td></tr> -->
                                                <tr>
                                                    <td>1</td>
                                                    <td>2</td>
                                                    <td>3</td>
                                                    <td>4</td>
                                                    <td>5</td>
                                                    <td>6</td>
                                                    <td>7</td>
                                                    <td>8</td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $v->tahun }}</td>
                                                    @if(Auth::user()->user_type == "A")
                                                        @foreach($kab_kota as $kk)
                                                            @if($v->daerah == $kk->id)
                                                            <td>{{ $kk->nama_kab_kota }}</td>
                                                            @endif
                                                        @endforeach
                                                    @elseif(Auth::user()->user_type == "B")
                                                        @foreach($kecamatan as $kc)
                                                            @if($v->daerah == $kc->id)
                                                            <td>{{ $kc->nama_kecamatan }}</td>
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                    @if($v->status_pengajuan == true)
                                                    <td><button class="btn btn-sm btn-success">Sudah diajukan</button></td>
                                                    @elseif($v->status_pengajuan == false)
                                                    <td><button class="btn btn-sm btn-danger">Belum diajukan</button></td>
                                                    @endif

                                                    <td>{{ $v->tanggal_pengajuan }}</td>

                                                    @if($v->status_verifikasi == 0)
                                                    <td><button class="btn btn-sm btn-warning">Menunggu diverifikasi</button></td>
                                                    @elseif($v->status_verifikasi == 1)
                                                    <td><button class="btn btn-sm btn-success">Sudah diverifikasi</button></td>
                                                    @elseif($v->status_verifikasi == 2)
                                                    <td><button class="btn btn-sm btn-danger">Belum diverifikasi</button></td>
                                                    @endif
                                                    
                                                    @if($v->status_verifikasi == 0)
                                                    <td>Menunggu diverifikasi</td>
                                                    @elseif($v->status_verifikasi == 1)
                                                    <td>{{ $v->tanggal_verifikasi }}</td>
                                                    @elseif($v->status_verifikasi == 2)
                                                    <td>Belum diverifikasi</td>
                                                    @endif
                                                    
                                                    @if(Auth::user()->user_type == "A" OR Auth::user()->user_type == "B")
                                                        @if($v->status_verifikasi == 1)
                                                        <td>Sudah diverifikasi<br><p><small>Catatan: {{ $v->catatan }}</small></p></td>
                                                        @elseif($v->status_verifikasi == 0 OR $v->status_verifikasi == 2)
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-sm-{{ $v->id }}">
                                                                <i class="fas fa-check"></i> Verifikasi
                                                            </button>
                                                            @if($v->status_verifikasi == 2)
                                                            <p><small>Catatan: {{ $v->catatan }}</small></p>
                                                            @endif
                                                        </td>
                                                        @endif
                                                    @endif
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                Halaman : {{ $verifikasi->currentPage() }} |
                                Jumlah Data : {{ $verifikasi->total() }} |
                                Data per Halaman : {{ $verifikasi->perPage() }}
                                {{ $verifikasi->links() }}
                            </div>
                        </div>
                    <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@foreach($verifikasi as $vk)
<div class="modal fade" id="modal-sm-{{ $vk->id }}">
<div class="modal-dialog modal-sm">
    <div class="modal-content">
    <div class="modal-header">
        <h6 class="modal-title">Verifikasi (@if(Auth::user()->user_type == "A")
                                                @foreach($kab_kota as $kk)
                                                    @if($v->daerah == $kk->id)
                                                        {{ $kk->nama_kab_kota }}
                                                    @endif
                                                @endforeach
                                            @elseif(Auth::user()->user_type == "B")
                                                @foreach($kecamatan as $kc)
                                                    @if($v->daerah == $kc->id)
                                                        {{ $kc->nama_kecamatan }}
                                                    @endif
                                                @endforeach
                                            @endif 
                                            {{ $v->tahun }} )</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form action="{{ route('verifikasi.update', $v->id) }}" method="POST">
        {{ csrf_field() }}
            <div>
                <textarea class="form-control" name="catatan" id="catatan" placeholder="Catatan&hellip;"></textarea>
            </div>
            <div class="row m-3">
                <div class="col-sm-6">
                    <input class="form-check-input" type="radio" name="verifikasi" value="1">
                    <label class="form-check-label">Verifikasi</label>
                </div>
                <div class="col-sm-6">
                    <input class="form-check-input" type="radio" name="verifikasi" value="2">
                    <label class="form-check-label">Tolak</label>
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        </form>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endforeach
@endsection