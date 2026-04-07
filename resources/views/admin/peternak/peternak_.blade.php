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
                                <div class="row">
                                    <div class="col">
                                        <h3 class="card-title">Data Peternak 
                                            <a href="{{ route('peternak.form') }}" class="btn btn-md btn-primary ml-2"><i class="fas fa-plus"></i> Tambah</a>
                                            @if(!empty($_REQUEST['kab_kota']) OR !empty($_REQUEST['kecamatan']) OR !empty($_REQUEST['desa_kel']) OR !empty($_REQUEST['search']))
                                            <a href="{{ route('peternak.export').'?kab_kota='.$_REQUEST['kab_kota'].'&kecamatan='.$_REQUEST['kecamatan'].'&desa_kel='.$_REQUEST['desa_kel'].'&search='.$_REQUEST['search'] }}" class="btn btn-md btn-success ml-2"><i class="fas fa-table"></i> Export</a>
                                            @else
                                            <a href="{{ route('peternak.export').'?kab_kota=&kecamatan=&desa_kel=&search=' }}" class="btn btn-md btn-success ml-2"><i class="fas fa-table"></i> Export</a>
                                            @endif
                                        </h3>
                                    </div>

                                    <div class="col container-fluid">
                                        <form class="row float-right" action="{{ route('peternak.search') }}" method="GET">
                                            {{csrf_field()}}
                                            @if(Auth::user()->user_type == 'A')
                                            <div class="col">
                                                <select name="kab_kota" id="kab_kota" class="form-control">
                                                    <option value="">Pilih Kabupaten/Kota</option>
                                                    @foreach($kab_kota as $kk)
                                                    <option value="{{ $kk->id }}">{{ $kk->nama_kab_kota }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <select name="kecamatan" id="kecamatan" class="form-control">
                                                    <option value="">Pilih Kecamatan</option>
                                                    @foreach($kecamatan as $kc)
                                                    <option value="{{ $kc->id }}">{{ $kc->nama_kecamatan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <select name="desa_kel" id="desa_kel" class="form-control">
                                                    <option value="">Pilih Desa/Kelurahan</option>
                                                    @foreach($desa_kel as $dk)
                                                    <option value="{{ $dk->id }}">{{ $dk->nama_desa_kel }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @elseif(Auth::user()->user_type == 'B')
                                            <div class="col">
                                                <select name="kecamatan" id="kecamatan" class="form-control">
                                                    <option value="">Pilih Kecamatan</option>
                                                    @foreach($kecamatan as $kc)
                                                    <option value="{{ $kc->id }}">{{ $kc->nama_kecamatan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <select name="desa_kel" id="desa_kel" class="form-control">
                                                    <option value="">Pilih Desa/Kelurahan</option>
                                                    @foreach($desa_kel as $dk)
                                                    <option value="{{ $dk->id }}">{{ $dk->nama_desa_kel }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @elseif(Auth::user()->user_type == 'C')
                                            <div class="col">
                                                <select name="desa_kel" id="desa_kel" class="form-control">
                                                    <option value="">Pilih Desa/Kelurahan</option>
                                                    @foreach($desa_kel as $dk)
                                                    <option value="{{ $dk->id }}">{{ $dk->nama_desa_kel }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @endif
                                            <div class="col">
                                                <input type="text" name="search" id="search" class="form-control" placeholder="Search Nama Peternak">
                                            </div>
                                            <div class="col">
                                                <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>No. Hp</th>
                                        <th>Desa/Kelurahan</th>
                                        @if(Auth::user()->user_type == "C")
                                            <th>Aksi</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($peternak as $p)
                                            @if($p == '')
                                                <!-- <tr><td><h3>Tidak ada data</h3></td></tr> -->
                                                <tr>
                                                    <td>1</td>
                                                    <td>2</td>
                                                    <td>3</td>
                                                    <td>4</td>
                                                    <td>5</td>
                                                    <td>6</td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $p->nik }}</td>
                                                    <td>{{ $p->nama }}</td>
                                                    <td>{{ $p->hp }}</td>
                                                    <!-- <td><?php
                                                        // foreach($desa_kel as $dk){
                                                        //     if($p->desa_kel_id == $dk->id){
                                                        //         $dk->nama_desa_kel;
                                                        //     }
                                                        // }
                                                    ?></td> -->
                                                    <td>
                                                        @foreach($desa_kel as $dk)
                                                            @if($p->desa_kel_id == $dk->id)
                                                                {{ $dk->nama_desa_kel }}
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    @if(Auth::user()->user_type == "C")
                                                        <td>
                                                            <div class="d-flex">
                                                                <a href="{{ route('peternak.edit', $p->id) }}" class="btn btn-sm btn-warning mr-2"><i class="fas fa-edit"></i> Edit</a>
                                                                <form action="{{ route('peternak.delete', $p->id) }}" method="POST">
                                                                    {{ csrf_field() }}
                                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda  yakin untuk menghapus data ?')"><i class="fas fa-trash-alt"></i> Hapus</button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                Halaman : {{ $peternak->currentPage() }} |
                                Jumlah Data : {{ $peternak->total() }} |
                                Data per Halaman : {{ $peternak->perPage() }}
                                {{ $peternak->links() }}
                            </div>
                        </div>
                    <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection