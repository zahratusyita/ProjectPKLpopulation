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
                                    <div>
                                        <h3 class="card-title">Data Peternak 
                                            @if(Auth::user()->user_type == 'C')
                                            <a href="{{ route('peternak.form') }}" class="btn btn-sm btn-primary ml-2"><i class="fas fa-plus"></i> Tambah</a>
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-import-peternak">
                                                <i class="fas fa-file-import"></i> Import
                                            </button>
                                            @endif
                                            @if(!empty($_REQUEST['kab_kota']) OR !empty($_REQUEST['kecamatan']) OR !empty($_REQUEST['desa_kel']) OR !empty($_REQUEST['search']))
                                            <a href="{{ route('peternak.export').'?kab_kota='.$_REQUEST['kab_kota'].'&kecamatan='.$_REQUEST['kecamatan'].'&desa_kel='.$_REQUEST['desa_kel'].'&search='.$_REQUEST['search'] }}" class="btn btn-sm btn-success ml-2"><i class="fas fa-table"></i> Export</a>
                                            @else
                                            <a href="{{ route('peternak.export').'?kab_kota=&kecamatan=&desa_kel=&search=' }}" class="btn btn-sm btn-success ml-2"><i class="fas fa-table"></i> Export</a>
                                            @endif
                                        </h3>
                                    </div>
                                <!-- </div> -->
                            </div>
                            <!-- <div class="col-md container-fluid"> -->
                            <div class="card-header">
                                <form class="row" action="{{ route('peternak.search') }}" method="GET">
                                    {{csrf_field()}}
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
                                        <!-- <label for="desa_kel">Desa/Kelurahan</label> -->
                                        <select name="desa_kel" id="desa_kel" class="form-control p-1">
                                            <option value="">Pilih Desa/Kelurahan</option>
                                        </select>
                                    </div>
                                    <div class="col-md">
                                        <!-- <label for="search">Peternak</label> -->
                                        <input type="text" name="search" id="search" class="form-control" placeholder="Nama Peternak">
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
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Tempat Lahir</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Jenis Kelamin</th>
                                        <th>No. Hp</th>
                                        <th>Desa/Kelurahan</th>
                                        <th>Alamat</th>
                                        <th>pekerjaan</th>
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
                                                    <td>7</td>
                                                    <td>8</td>
                                                    <td>9</td>
                                                    <td>10</td>
                                                    <td>11</td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $p->nik }}</td>
                                                    <td>{{ $p->nama }}</td>
                                                    <td>{{ $p->tempat_lahir }}</td>
                                                    <td>{{ $p->tanggal_lahir }}</td>
                                                    <td>
                                                        <?php
                                                            if($p->jenis_kelamin == 1){
                                                                echo 'Laki-laki';
                                                            }elseif($p->jenis_kelamin == 2){
                                                                echo 'Perempuan';
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>{{ $p->hp }}</td>
                                                    <td>
                                                        @foreach($desa_kel as $dk)
                                                            @if($p->desa_kel_id == $dk->id)
                                                                {{ $dk->nama_desa_kel }}
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>{{ $p->alamat }}</td>
                                                    <td>
                                                        <?php
                                                            if($p->pekerjaan == 1){
                                                                echo 'ASN/TNI/Polri';
                                                            }elseif($p->pekerjaan == 2){
                                                                echo 'Peternak';
                                                            }elseif($p->pekerjaan == 3){
                                                                echo 'Petani';
                                                            }elseif($p->pekerjaan == 4){
                                                                echo 'Swasta';
                                                            }elseif($p->pekerjaan == 5){
                                                                echo 'Wiraswasta';
                                                            }elseif($p->pekerjaan == 6){
                                                                echo 'Pensiunan ASN/TNI/Polri';
                                                            }elseif($p->pekerjaan == 7){
                                                                echo 'Tidak Bekerja';
                                                            }
                                                        ?>
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

<div class="modal fade" id="modal-import-peternak">
<div class="modal-dialog modal-md">
    <div class="modal-content">
    <div class="modal-header">
        <h6>Import Data dari File Excel</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form action="{{ route('peternak.import') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
            <div>
                <a href="{{ asset('assets/dist/img/Template-Data-Peternak.xls') }}">Download Format File</a>
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