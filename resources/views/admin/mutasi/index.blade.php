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
                                        <div>
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                            @if (session('success'))
                                                <div class="alert alert-success">
                                                    {{ session('success') }}
                                                </div>
                                            @endif
                                        </div>
                                        <h3 class="card-title">Data {{ ucfirst($jenis) }} Ternak 
                                        @if(Auth::user()->user_type == 'C')
                                            @if($status_verifikasi['status_pengajuan'] == 0)
                                                <a href="{{ url('mutasi/'.$jenis.'/form') }}" class="btn btn-sm btn-primary ml-2"><i class="fas fa-plus"></i> Tambah</a>
                                            @endif
                                        @endif
                                    </h3>
                                </div>
                                <div class="col container-fluid">
                                    <div class="row float-right">
                                        @if(Auth::user()->user_type == 'B')
                                            @if($status_verifikasi['status_pengajuan'] == 0)
                                                <a href="{{ route('ajukan') }}" class="btn btn-sm btn-primary ml-2"><i class="fas fa-paper-plane"></i> Ajukan Data Tahun Ini</a>
                                            @elseif($status_verifikasi['status_pengajuan'] == 1)
                                                @if($status_verifikasi['status_verifikasi'] == 0)
                                                    <button class="btn btn-sm btn-warning ml-2">Menunggu Verifikasi Di Provinsi</button>
                                                @elseif($status_verifikasi['status_verifikasi'] == 1)
                                                    <button class="btn btn-sm btn-success ml-2">Data Telah Diverifikasi Di Provinsi</button>
                                                @else($status_verifikasi['status_verifikasi'] == 2)
                                                    <p><b>Catatan:</b> {{ $status_verifikasi['catatan'] }}</p>
                                                    <form action="{{ route('verifikasi.update', $status_verifikasi['id']) }}" method="POST">
                                                        {{ csrf_field() }}
                                                        <button type="submit" class="btn btn-sm btn-primary ml-2"><i class="fas fa-paper-plane"></i> Ajukan Ulang Data Tahun Ini</button>
                                                    </form>
                                                @endif
                                            @endif
                                        @elseif(Auth::user()->user_type == 'C')
                                            @if($status_verifikasi['status_pengajuan'] == 0)
                                                <a href="{{ route('ajukan') }}" class="btn btn-sm btn-primary ml-2"><i class="fas fa-paper-plane"></i> Ajukan Data Tahun Ini</a>
                                            @elseif($status_verifikasi['status_pengajuan'] == 1)
                                                @if($status_verifikasi['status_verifikasi'] == null)
                                                    <button class="btn btn-sm btn-warning ml-2">Menunggu Verifikasi Di Kabupaten/Kota</button>
                                                @elseif($status_verifikasi['status_verifikasi'] == 1)
                                                    <button class="btn btn-sm btn-success ml-2">Data Telah Diverifikasi Di Kabupaten/Kota</button>
                                                @elseif($status_verifikasi['status_verifikasi'] == 2)
                                                    <p><b>Catatan:</b> {{ $status_verifikasi['catatan'] }}</p>
                                                    <form action="{{ route('verifikasi.update', $status_verifikasi['id']) }}" method="POST">
                                                        {{ csrf_field() }}
                                                        <button type="submit" class="btn btn-sm btn-primary ml-2"><i class="fas fa-paper-plane"></i> Ajukan Ulang Data Tahun Ini</button>
                                                    </form>
                                                @endif
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card-header">
                                <form class="row" action="" method="GET">
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
                                        <select name="desa_kel" id="desa_kel" class="form-control p-1">
                                            <option value="">Pilih Desa/Kelurahan</option>
                                        </select>
                                    </div>
                                    <div class="col-md">
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
                                    <th rowspan="2" style="vertical-align:middle;">Tanggal</th>
                                    <th rowspan="2" style="vertical-align:middle;">Peternak</th>
                                    <th rowspan="2" style="vertical-align:middle;">NIK</th>
                                    <th rowspan="2" style="vertical-align:middle; border-right:1px solid;">Desa/Kelurahan</th>
                                    <th colspan="3" style="text-align:center">Sapi Jantan</th>
                                    <th colspan="3" style="text-align:center; border-right:1px solid;">Sapi Betina</th>
                                    <th colspan="3" style="text-align:center">Kerbau Jantan</th>
                                    <th colspan="3" style="text-align:center; border-right:1px solid;">Kerbau Betina</th>
                                    <th colspan="3" style="text-align:center">Kuda Jantan</th>
                                    <th colspan="3" style="text-align:center; border-right:1px solid;">Kuda Betina</th>
                                    <th colspan="3" style="text-align:center">Kambing Jantan</th>
                                    <th colspan="3" style="text-align:center; border-right:1px solid;">Kambing Betina</th>
                                    <th colspan="3" style="text-align:center">Babi Jantan</th>
                                    <th colspan="3" style="text-align:center; border-right:1px solid;">Babi Betina</th>
                                    <th colspan="3" style="text-align:center">Domba Jantan</th>
                                    <th colspan="3" style="text-align:center; border-right:1px solid;">Domba Betina</th>
                                    <th rowspan="2" style="vertical-align:middle;">Ayam Ras</th>
                                    <th rowspan="2" style="vertical-align:middle;">Ayam Buras</th>
                                    <th rowspan="2" style="vertical-align:middle;">Ayam Layer</th>
                                    <th rowspan="2" style="vertical-align:middle;">Itik</th>
                                    <th rowspan="2" style="vertical-align:middle;">Puyuh</th>
                                    @if(Auth::user()->user_type == "C")
                                    <th rowspan="3" style="vertical-align:middle;">Aksi</th>
                                    @endif
                                </tr>
                                <tr>
                                    <th>Anak</th>
                                    <th>Muda</th>
                                    <th style="border-right:1px solid;">Dewasa</th>
                                    <th>Anak</th>
                                    <th>Muda</th>
                                    <th style="border-right:1px solid;">Dewasa</th>
                                    <th>Anak</th>
                                    <th>Muda</th>
                                    <th style="border-right:1px solid;">Dewasa</th>
                                    <th>Anak</th>
                                    <th>Muda</th>
                                    <th style="border-right:1px solid;">Dewasa</th>
                                    <th>Anak</th>
                                    <th>Muda</th>
                                    <th style="border-right:1px solid;">Dewasa</th>
                                    <th>Anak</th>
                                    <th>Muda</th>
                                    <th style="border-right:1px solid;">Dewasa</th>
                                    <th>Anak</th>
                                    <th>Muda</th>
                                    <th style="border-right:1px solid;">Dewasa</th>
                                    <th>Anak</th>
                                    <th>Muda</th>
                                    <th style="border-right:1px solid;">Dewasa</th>
                                    <th>Anak</th>
                                    <th>Muda</th>
                                    <th style="border-right:1px solid;">Dewasa</th>
                                    <th>Anak</th>
                                    <th>Muda</th>
                                    <th style="border-right:1px solid;">Dewasa</th>
                                    <th>Anak</th>
                                    <th>Muda</th>
                                    <th style="border-right:1px solid;">Dewasa</th>
                                    <th>Anak</th>
                                    <th>Muda</th>
                                    <th style="border-right:1px solid;">Dewasa</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($mutasi as $t)
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
                                                <td>16</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $t->tanggal }}</td>
                                                <td>{{ $t->nama }}</td>
                                                <td>{{ $t->nik }}</td>
                                                <td style="border-right:1px solid;">
                                                    @foreach($desa_kel as $dk)
                                                        @if($t->desa_kel_id == $dk->id)
                                                            {{ $dk->nama_desa_kel }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td style="text-align:center">{{ $t->sapi_anak_jantan }}</td>
                                                <td style="text-align:center">{{ $t->sapi_muda_jantan }}</td>
                                                <td style="text-align:center; border-right:1px solid;">{{ $t->sapi_dewasa_jantan }}</td>
                                                <td style="text-align:center">{{ $t->sapi_anak_betina }}</td>
                                                <td style="text-align:center">{{ $t->sapi_muda_betina }}</td>
                                                <td style="text-align:center; border-right:1px solid;">{{ $t->sapi_dewasa_betina }}</td>
                                                <td style="text-align:center">{{ $t->kerbau_anak_jantan }}</td>
                                                <td style="text-align:center">{{ $t->kerbau_muda_jantan }}</td>
                                                <td style="text-align:center; border-right:1px solid;">{{ $t->kerbau_dewasa_jantan }}</td>
                                                <td style="text-align:center">{{ $t->kerbau_anak_betina }}</td>
                                                <td style="text-align:center">{{ $t->kerbau_muda_betina }}</td>
                                                <td style="text-align:center; border-right:1px solid;">{{ $t->kerbau_dewasa_betina }}</td>
                                                <td style="text-align:center">{{ $t->kuda_anak_jantan }}</td>
                                                <td style="text-align:center">{{ $t->kuda_muda_jantan }}</td>
                                                <td style="text-align:center; border-right:1px solid;">{{ $t->kuda_dewasa_jantan }}</td>
                                                <td style="text-align:center">{{ $t->kuda_anak_betina }}</td>
                                                <td style="text-align:center">{{ $t->kuda_muda_betina }}</td>
                                                <td style="text-align:center; border-right:1px solid;">{{ $t->kuda_dewasa_betina }}</td>
                                                <td style="text-align:center">{{ $t->kambing_anak_jantan }}</td>
                                                <td style="text-align:center">{{ $t->kambing_muda_jantan }}</td>
                                                <td style="text-align:center; border-right:1px solid;">{{ $t->kambing_dewasa_jantan }}</td>
                                                <td style="text-align:center">{{ $t->kambing_anak_betina }}</td>
                                                <td style="text-align:center">{{ $t->kambing_muda_betina }}</td>
                                                <td style="text-align:center; border-right:1px solid;">{{ $t->kambing_dewasa_betina }}</td>
                                                <td style="text-align:center">{{ $t->babi_anak_jantan }}</td>
                                                <td style="text-align:center">{{ $t->babi_muda_jantan }}</td>
                                                <td style="text-align:center; border-right:1px solid;">{{ $t->babi_dewasa_jantan }}</td>
                                                <td style="text-align:center">{{ $t->babi_anak_betina }}</td>
                                                <td style="text-align:center">{{ $t->babi_muda_betina }}</td>
                                                <td style="text-align:center; border-right:1px solid;">{{ $t->babi_dewasa_betina }}</td>
                                                <td style="text-align:center">{{ $t->domba_anak_jantan }}</td>
                                                <td style="text-align:center">{{ $t->domba_muda_jantan }}</td>
                                                <td style="text-align:center; border-right:1px solid;">{{ $t->domba_dewasa_jantan }}</td>
                                                <td style="text-align:center">{{ $t->domba_anak_betina }}</td>
                                                <td style="text-align:center">{{ $t->domba_muda_betina }}</td>
                                                <td style="text-align:center; border-right:1px solid;">{{ $t->domba_dewasa_betina }}</td>
                                                <td style="text-align:center">{{ $t->ayam_ras + 0 }}</td>
                                                <td style="text-align:center">{{ $t->ayam_buras + 0 }}</td>
                                                <td style="text-align:center">{{ $t->ayam_petelur + 0 }}</td>
                                                <td style="text-align:center">{{ $t->itik + 0 }}</td>
                                                <td style="text-align:center">{{ $t->puyuh + 0 }}</td>
                                                @if(Auth::user()->user_type == "C")
                                                <td>
                                                    @if($status_verifikasi['status_pengajuan'] == 1)
                                                        @if($status_verifikasi['status_verifikasi'] == 0)
                                                            <p>Menunggu verifikasi data</p>
                                                        @elseif($status_verifikasi['status_verifikasi'] == 1)
                                                            <p>Data sudah diverifikasi</p>
                                                        @elseif($status_verifikasi['status_verifikasi'] == 2)
                                                            <div class="d-flex">
                                                                <a href="{{ url('mutasi/'.$jenis.'/edit/'.$t->id) }}" class="btn btn-sm btn-warning mr-2"><i class="fas fa-edit"></i> Edit</a>
                                                                <form action="{{ url('mutasi/'.$jenis.'/delete/'.$t->id) }}" method="POST">
                                                                    {{ csrf_field() }}
                                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin untuk menghapus data ?')"><i class="fas fa-trash-alt"></i> Hapus</button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div class="d-flex">
                                                            <a href="{{ url('mutasi/'.$jenis.'/edit/'.$t->id) }}" class="btn btn-sm btn-warning mr-2"><i class="fas fa-edit"></i> Edit</a>
                                                            <form action="{{ url('mutasi/'.$jenis.'/delete/'.$t->id) }}" method="POST">
                                                                {{ csrf_field() }}
                                                                <button class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin untuk menghapus data ?')"><i class="fas fa-trash-alt"></i> Hapus</button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                </td>
                                                @endif
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                Halaman : {{ $mutasi->currentPage() }} |
                                Jumlah Data : {{ $mutasi->total() }} |
                                Data per Halaman : {{ $mutasi->perPage() }}
                                {{ $mutasi->links() }}
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