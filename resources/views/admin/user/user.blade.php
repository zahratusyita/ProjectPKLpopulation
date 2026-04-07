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
                                <div>
                                    <h3 class="card-title">Data User 
                                        <a href="{{ route('user.form') }}" class="btn btn-sm btn-primary ml-2"><i class="fas fa-plus"></i> Tambah</a>
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-import-user">
                                            <i class="fas fa-file-import"></i> Import
                                        </button>
                                    </h3>
                                </div>
                            </div>

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
                                            @foreach($kab_kota as $kk)
                                                @if($u->kab_kota_id == $kk->id)
                                                    <td><center>{{ $kk->nama_kab_kota }}</center></td>
                                                @endif
                                            @endforeach

                                            <td><center>-</center></td>
                                        @elseif($u->user_type == "C")
                                        <td>Admin Kecamatan</td>
                                            @foreach($kab_kota as $kk)
                                                @if($u->kab_kota_id == $kk->id)
                                                    <td><center>{{ $kk->nama_kab_kota }}</center></td>
                                                @endif
                                            @endforeach

                                            @foreach($kecamatan as $kc)
                                                @if($u->kecamatan_id == $kc->id)
                                                    <td><center>{{ $kc->nama_kecamatan }}</center></td>
                                                @endif
                                            @endforeach
                                        @endif

                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('user.edit', $u->id) }}" class="btn btn-sm btn-warning mr-2"><i class="fas fa-edit"></i> Edit</a>
                                                <form action="{{ route('user.delete', $u->id) }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda  yakin untuk menghapus data ?')"><i class="fas fa-trash-alt"></i> Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                Halaman : {{ $user->currentPage() }} |
                                Jumlah Data : {{ $user->total() }} |
                                Data per Halaman : {{ $user->perPage() }}
                                {{ $user->links() }}
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