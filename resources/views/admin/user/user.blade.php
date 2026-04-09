@extends('layouts.admin')

@section('content')
<?php
    $no = 1;
?>
<div class="content content-wrapper">
    <div class="content-header">
        <section class="container">
            <div class="container-fluid">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 mt-2">
                    <div class="mb-3 mb-md-0">
                        <h1 class="m-0 font-weight-bold" style="color: #1e3a5f !important; font-size: 1.8rem;">Data User</h1>
                    </div>
                    
                    <div class="d-flex flex-column align-items-md-end">
                        <div class="px-3 py-2 bg-white d-inline-flex align-items-center rounded-pill shadow-sm border border-light mb-0">
                            <i class="fas fa-calendar-alt mr-2" style="color:#1e3a5f; font-size: 1.2rem;"></i>
                            <strong style="color: #475569; font-size: 0.9rem;" class="mr-2">Tahun Data:</strong> 
                            <span class="badge px-3 py-1 rounded-pill" style="background-color:#1e3a5f; color:#fff; font-size:0.95rem; font-weight:700;">
                                {{ session()->get('tahun_data') ?? date('Y') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header">
                                <form class="row" action="{{ route('user.search') }}" method="GET">
                                    {{csrf_field()}}
                                    <div class="col-md">
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
                                        <input type="text" name="search" id="search" class="form-control" placeholder="Nama User">
                                    </div>
                                    <div class="col-md">
                                        <button type="submit" class="btn btn-light shadow-sm font-weight-bold" style="background-color: #ffffff; border-color: #cbd5e1; color: #334155;">
                                            <i class="fas fa-search"></i> Cari
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
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Kabupaten/Kota</th>
                                    <th>Kecamatan</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($user as $u)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $u->name }}</td>
                                        <td>{{ $u->email }}</td>

                                        @if($u->user_type == "A")
                                        <td>Admin Provinsi</td>
                                        <td><center>-</center></td>
                                        <td><center>-</center></td>
                                        @elseif($u->user_type == "B")
                                        <td>Admin Kab./Kota</td>
                                        <td>
                                            <center>
                                                @php $found_kab = false; @endphp
                                                @foreach($kab_kota as $kk)
                                                    @if($u->kab_kota_id == $kk->id)
                                                        {{ $kk->nama_kab_kota }}
                                                        @php $found_kab = true; @endphp
                                                    @endif
                                                @endforeach
                                                @if(!$found_kab) - @endif
                                            </center>
                                        </td>
                                        <td><center>-</center></td>
                                        @elseif($u->user_type == "C")
                                        <td>Admin Kecamatan</td>
                                        <td>
                                            <center>
                                                @php $found_kab = false; @endphp
                                                @foreach($kab_kota as $kk)
                                                    @if($u->kab_kota_id == $kk->id)
                                                        {{ $kk->nama_kab_kota }}
                                                        @php $found_kab = true; @endphp
                                                    @endif
                                                @endforeach
                                                @if(!$found_kab) - @endif
                                            </center>
                                        </td>
                                        <td>
                                            <center>
                                                @php $found_kec = false; @endphp
                                                @foreach($kecamatan as $kc)
                                                    @if($u->kecamatan_id == $kc->id)
                                                        {{ $kc->nama_kecamatan }}
                                                        @php $found_kec = true; @endphp
                                                    @endif
                                                @endforeach
                                                @if(!$found_kec) - @endif
                                            </center>
                                        </td>
                                        @else
                                        <td>Tidak Diketahui</td>
                                        <td><center>-</center></td>
                                        <td><center>-</center></td>
                                        @endif

                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('user.edit', $u->id) }}" class="btn btn-sm shadow-sm mr-2" style="background-color: #F59E0B; border-color: #F59E0B; color: #ffffff; width: 90px; text-align: center;"><i class="fas fa-edit"></i> Edit</a>
                                                <form action="{{ route('user.delete', $u->id) }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <button class="btn btn-sm shadow-sm" style="background-color: #EF4444; border-color: #EF4444; color: #ffffff; width: 90px; text-align: center;" onclick="return confirm('Apakah Anda yakin untuk menghapus data?')"><i class="fas fa-trash-alt"></i> Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer bg-white border-top-0 pt-4 pb-4 rounded-bottom">
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                                    <div class="text-muted mb-3 mb-md-0">
                                        Halaman : {{ $user->currentPage() }} |
                                        Jumlah Data : {{ $user->total() }} |
                                        Data per Halaman : {{ $user->perPage() }}
                                        {{ $user->links() }}
                                    </div>
                                    <div class="d-flex justify-content-end align-items-center mt-2 mt-md-0 pr-1">
                                        <a href="{{ route('user.form') }}" class="btn btn-sm shadow-sm mr-3" style="background-color: #1e3a5f; border-color: #1e3a5f; color: #ffffff; width: 90px; text-align: center;">
                                            <i class="fas fa-plus"></i> Tambah
                                        </a>
                                        <button type="button" class="btn btn-sm shadow-sm" data-toggle="modal" data-target="#modal-import-user" style="background-color: #1e3a5f; border-color: #1e3a5f; color: #ffffff; width: 90px; text-align: center;">
                                            <i class="fas fa-file-import"></i> Import
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<div class="modal fade" id="modal-import-user">
<div class="modal-dialog modal-md">
    <div class="modal-content">
    <div class="modal-header">
        <h6>Import Data dari File Excel</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form action="{{ route('user.import') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
            <div>
                <a href="{{ asset('assets/dist/img/Template-Data-User.xls') }}">Download Format File</a>
            </div>
            <div class="row m-3">
                <input type="file" class="form-control" name="file">
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
@endsection