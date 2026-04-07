@extends('layouts.admin')

@section('content')
<div class="content content-wrapper">
    <div class="content-header">
        <section class="container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div>
                                    <h3 class="card-title">Data Ternak 
                                        <a href="{{ route('ternak.form') }}" class="btn btn-sm btn-primary ml-2"><i class="fas fa-plus"></i> Tambah</a>
                                        @if(!empty($_REQUEST['tahun']) OR !empty($_REQUEST['search']) OR !empty($_REQUEST['kab_kota']) OR !empty($_REQUEST['kecamatan']) OR !empty($_REQUEST['desa_kel']))
                                        <a href="{{ route('ternak.export').'?tahun='.$_REQUEST['tahun'].'&search='.$_REQUEST['search'] }}" class="btn btn-md btn-success ml-2"><i class="fas fa-table"></i> Export</a>
                                        @else
                                        <a href="{{ route('ternak.export').'?tahun=&search=' }}" class="btn btn-md btn-success ml-2"><i class="fas fa-table"></i> Export</a>
                                        @endif
                                    </h3>
                                </div>
                            </div>

                            <!-- <div class="col container-fluid">
                                <form class="row float-right" action="{{ route('ternak.search') }}" method="GET">
                                    {{csrf_field()}}
                                    <div class="col">
                                        <select name="tahun" id="tahun" class="form-control">
                                            <option value="">Pilih Tahun</option>
                                            @for($t=2022; $t<2026; $t++)
                                            <option value="{{ $t }}">{{ $t }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col">
                                        <input type="text" name="search" id="search" class="form-control" placeholder="Search">
                                    </div>
                                    <div class="col">
                                        <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div> -->
                            <div class="card-header">
                                <form class="row" action="{{ route('ternak.search') }}" method="GET">
                                    {{csrf_field()}}
                                    <div class="col">
                                        <select name="tahun" id="tahun" class="form-control">
                                            <option value="">Pilih Tahun</option>
                                            @for($t=2022; $t<2026; $t++)
                                            <option value="{{ $t }}">{{ $t }}</option>
                                            @endfor
                                        </select>
                                    </div>
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
                                    <th rowspan="2" style="vertical-align:middle;">No.</th>
                                    <th rowspan="2" style="vertical-align:middle;">Peternak</th>
                                    <th rowspan="2" style="vertical-align:middle;">Desa/Kelurahan</th>
                                    <th colspan="11" style="text-align:center;">Jumlah</th>
                                    @if(Auth::user()->user_type == "C")
                                    <th>Aksi</th>
                                    @endif
                                </tr>
                                <tr>
                                <th>Sapi</th>
                                    <th>Kerbau</th>
                                    <th>Kuda</th>
                                    <th>Kambing</th>
                                    <th>Babi</th>
                                    <th>Domba</th>
                                    <th>Ayam Ras</th>
                                    <th>Ayam Buras</th>
                                    <th>Ayam Layer</th>
                                    <th>Itik</th>
                                    <th>Puyuh</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($ternak as $t)
                                        @if($t == '')
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
                                                <td>12</td>
                                                <td>13</td>
                                                <td>14</td>
                                                <td>15</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>{{ $t->id }}</td>
                                                <td>{{ $t->peternak->nama }}</td>
                                                <td>@foreach($desa_kel as $dk)
                                                        @if($t->peternak->desa_kel_id == $dk->id)
                                                            {{ $dk->nama_desa_kel }}
                                                        @endif
                                                    @endforeach</td>
                                                <td>{{ $t->sapi }}</td>
                                                <td>{{ $t->kerbau }}</td>
                                                <td>{{ $t->kuda }}</td>
                                                <td>{{ $t->kambing }}</td>
                                                <td>{{ $t->babi }}</td>
                                                <td>{{ $t->domba }}</td>
                                                <td>{{ $t->ayam_ras }}</td>
                                                <td>{{ $t->ayam_buras }}</td>
                                                <td>{{ $t->ayam_petelur }}</td>
                                                <td>{{ $t->itik }}</td>
                                                <td>{{ $t->puyuh }}</td>
                                                @if(Auth::user()->user_type == "C")
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('ternak.edit', $t->id) }}" class="btn btn-sm btn-warning mr-2"><i class="fas fa-edit"></i> Edit</a>
                                                        <form action="{{ route('ternak.delete', $t->id) }}" method="POST">
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
                        </div>
                    <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection