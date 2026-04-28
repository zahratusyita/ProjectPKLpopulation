@extends('layouts.admin')

@section('content')
<!-- Custom CSS for Modern UI -->
<style>
    /* Card Styling */
    .card-modern {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        background-color: #ffffff;
    }
    .card-modern .card-header {
        background-color: transparent;
        border-bottom: 1px solid rgba(0,0,0,.05);
        padding: 1.5rem;
    }
    
    /* Table Styling */
    .table-modern {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
    }
    .table-modern thead th {
        border-bottom: 2px solid #e2e8f0;
        color: #4a5568;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 1rem;
        letter-spacing: 0.05em;
        padding: 1.25rem 1rem;
    }
    .table-modern tbody tr {
        transition: all 0.2s ease;
    }
    .table-modern tbody tr:hover {
        background-color: #f8fafc;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    .table-modern tbody td {
        padding: 1.25rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #edf2f7;
        color: #1e293b;
        font-size: 1rem;
    }

    /* Filters Section */
    .filter-section {
        background-color: #f8fafc;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 1rem;
    }
    
    /* Buttons */
    .btn-modern {
        border-radius: 8px;
        font-weight: 500;
        padding: 0.5rem 1rem;
        transition: all 0.2s;
    }
    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
    }
    
    /* Action Buttons */
    .btn-action-icon {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        transition: all 0.2s;
    }
    .btn-action-icon:hover {
        transform: scale(1.1);
    }
</style>

<?php
    $no = 1;
?>
<div class="content content-wrapper border-0">
    <div class="content-header pt-4">
        <section class="container-fluid">
            <!-- Header Section with Buttons -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-start mb-4 mt-2">
                <div class="mb-3 mb-md-0 w-100">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div>
                            <h1 class="m-0 font-weight-bold" style="color: #1e3a5f !important; font-size: 1.8rem;">Data Ternak</h1>
                            <p class="text-muted mb-0 mt-1" style="font-size: 0.95rem;">Kelola dan pantau data populasi ternak yang terdaftar.</p>
                        </div>
                        <!-- Mobile Year Badge -->
                        <div class="d-flex flex-column align-items-md-end d-md-none">
                            <div class="px-3 py-2 bg-white d-inline-flex align-items-center rounded-pill shadow-sm border border-light">
                                <i class="fas fa-calendar-alt mr-2" style="color:#1e3a5f; font-size: 1.2rem;"></i>
                                <strong style="color: #475569; font-size: 0.9rem;" class="mr-2">Tahun Data:</strong>
                                <span class="badge px-3 py-1 rounded-pill" style="background-color:#1e3a5f; color:#fff; font-size:0.95rem; font-weight:700;">
                                    {{ session()->get('tahun_data') ?? date('Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex flex-wrap mt-3 align-items-center" style="gap: 0.75rem;">
                        @if(Auth::user()->user_type == 'C')
                            <a href="{{ route('ternak.form') }}" class="btn btn-primary btn-modern shadow-sm" style="background-color: #1e3a5f; border-color: #1e3a5f;">
                                <i class="fas fa-plus mr-1"></i> Tambah Data
                            </a>
                            <button type="button" class="btn btn-primary btn-modern shadow-sm" data-toggle="modal" data-target="#modal-import-ternak" style="background-color: #1e3a5f; border-color: #1e3a5f;">
                                <i class="fas fa-file-import mr-1"></i> Import
                            </button>
                        @endif
                    </div>
                </div>
                <div class="d-flex flex-column align-items-md-end d-none d-md-block pl-3">
                    <div class="px-3 py-2 bg-white d-inline-flex align-items-center rounded-pill shadow-sm border border-light">
                        <i class="fas fa-calendar-alt mr-2" style="color:#1e3a5f; font-size: 1.2rem;"></i>
                        <strong style="color: #475569; font-size: 0.9rem;" class="mr-2">Tahun Data:</strong>
                        <span class="badge px-3 py-1 rounded-pill" style="background-color:#1e3a5f; color:#fff; font-size:0.95rem; font-weight:700;">
                            {{ session()->get('tahun_data') ?? date('Y') }}
                        </span>
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 rounded-lg shadow-sm" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 rounded-lg shadow-sm" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif


            <div class="row">
                <div class="col-12">
                    <div class="card card-modern">
                        
                        <!-- Filter Section -->
                        <div class="card-header border-0 pb-0 pt-4">
                            <div class="filter-section">
                                <form class="form-row align-items-end" action="{{ route('ternak.search') }}" method="GET">
                                    {{csrf_field()}}
                                    <div class="col-md-3 mb-3 mb-md-0">
                                        <label class="text-dark font-weight-bold mb-2" for="kab_kota"><i class="fas fa-map-marker-alt mr-1"></i> Kabupaten/Kota</label>
                                        @if(Auth::user()->user_type == "A")
                                            <select name="kab_kota" id="kab_kota" class="form-control border-0 shadow-sm rounded" style="padding: 0.5rem;">
                                                <option value="">Pilih Kabupaten/Kota</option>
                                                @foreach($kab_kota as $kk)
                                                <option value="{{$kk->id}}">{{$kk->nama_kab_kota}}</option>
                                                @endforeach
                                            </select>
                                        @elseif(Auth::user()->user_type == "B" or Auth::user()->user_type == "C")
                                            <select name="kab_kota" id="kab_kota" class="form-control border-0 shadow-sm rounded" style="padding: 0.5rem;">
                                                @foreach($kab_kota as $kk)
                                                <option value="{{$kk->id}}">{{$kk->nama_kab_kota}}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                    <div class="col-md-3 mb-3 mb-md-0">
                                        <label class="text-dark font-weight-bold mb-2" for="kecamatan"><i class="fas fa-map mr-1"></i> Kecamatan</label>
                                        @if(Auth::user()->user_type == "A")
                                            <select name="kecamatan" id="kecamatan" class="form-control border-0 shadow-sm rounded" style="padding: 0.5rem;">
                                                <option value="">Pilih Kecamatan</option>
                                            </select>
                                        @elseif(Auth::user()->user_type == "B" or Auth::user()->user_type == "C")
                                            <select name="kecamatan" id="kecamatan" class="form-control border-0 shadow-sm rounded" style="padding: 0.5rem;">
                                                <option value="">Pilih Kecamatan</option>
                                                @foreach($kecamatan as $kc)
                                                <option value="{{ $kc->id }}">{{ $kc->nama_kecamatan }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                    <div class="col-md-2 mb-3 mb-md-0">
                                        <label class="text-dark font-weight-bold mb-2" for="desa_kel"><i class="fas fa-home mr-1"></i> Desa/Kelurahan</label>
                                        <select name="desa_kel" id="desa_kel" class="form-control border-0 shadow-sm rounded" style="padding: 0.5rem;">
                                            <option value="">Pilih Desa/Kel</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3 mb-md-0">
                                        <div class="input-group shadow-sm rounded">
                                            <input type="text" name="search" id="search" class="form-control border-0" placeholder="Cari nama peternak..." value="{{ request('search') }}" style="padding: 1.4rem 1rem;">
                                        </div>
                                    </div>
                                    <div class="col-md-1 mb-3 mb-md-0">
                                        <button type="submit" class="btn btn-light btn-block btn-modern shadow-sm font-weight-bold" style="background-color: #ffffff; border-color: #cbd5e1; color: #334155; padding: 0.45rem; font-size: 0.9rem;">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                            <table class="table table-modern text-nowrap align-middle">
                                <thead>
                                <tr>
                                    <th rowspan="2" style="vertical-align:middle;">No.</th>
                                    <th rowspan="2" style="vertical-align:middle;">Tahun</th>
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
                                    <th rowspan="3" style="vertical-align:middle; text-align:center;">Status</th>
                                    <th rowspan="3" style="vertical-align:middle; text-align:center;">Aksi</th>
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
                                                <td>16</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $t->tahun }}</td>
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
                                                <td style="text-align:center;">
                                                    @if($status_verifikasi['status_pengajuan'] == 1)
                                                        @if($status_verifikasi['status_verifikasi'] == 0)
                                                            <span class="badge" style="background-color: #fffff0; color: #d69e2e; padding: 0.4rem 0.6rem; border-radius: 6px; font-weight: 500; border: 1px solid #fef08a;">Menunggu</span>
                                                        @elseif($status_verifikasi['status_verifikasi'] == 1)
                                                            <span class="badge" style="background-color: #f0fff4; color: #38a169; padding: 0.4rem 0.6rem; border-radius: 6px; font-weight: 500; border: 1px solid #bbf7d0;">Tervalidasi</span>
                                                        @elseif($status_verifikasi['status_verifikasi'] == 2)
                                                            <span class="badge" style="background-color: #fee2e2; color: #dc2626; padding: 0.4rem 0.6rem; border-radius: 6px; font-weight: 500; border: 1px solid #fecaca;">Revisi</span>
                                                        @endif
                                                    @else
                                                        <span class="badge" style="background-color: #f1f5f9; color: #64748b; padding: 0.4rem 0.6rem; border-radius: 6px; font-weight: 500; border: 1px solid #e2e8f0;">Belum</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-center">
                                                    @if($status_verifikasi['status_pengajuan'] == 1 && $status_verifikasi['status_verifikasi'] != 2)
                                                        <button class="btn btn-secondary btn-action-icon shadow-sm mr-2" disabled style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; padding: 0; opacity:0.5;">
                                                            <i class="fas fa-pen text-white" style="font-size: 0.85rem;"></i>
                                                        </button>
                                                        <button class="btn btn-secondary btn-action-icon shadow-sm" disabled style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; padding: 0; opacity:0.5;">
                                                            <i class="fas fa-trash-alt text-white" style="font-size: 0.85rem;"></i>
                                                        </button>
                                                    @else
                                                        <a href="{{ route('ternak.edit', $t->id) }}" class="btn btn-warning btn-action-icon shadow-sm mr-2" title="Edit Data" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; padding: 0;">
                                                            <i class="fas fa-pen text-white" style="font-size: 0.85rem;"></i>
                                                        </a>
                                                        <form action="{{ route('ternak.delete', $t->id) }}" method="POST" class="m-0">
                                                            {{ csrf_field() }}
                                                            <button type="submit" class="btn btn-danger btn-action-icon shadow-sm" onclick="return confirm('Apakah Anda yakin untuk menghapus data ?')" title="Hapus Data" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; padding: 0;">
                                                                <i class="fas fa-trash-alt" style="font-size: 0.85rem;"></i>
                                                            </button>
                                                        </form>
                                                    @endif
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
                            <div class="card-footer bg-white border-top-0 pt-4 pb-4 rounded-bottom">
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                                    <div class="text-muted mb-3 mb-md-0" style="font-size: 1rem;">
                                        <i class="fas fa-info-circle mr-1 text-primary"></i> 
                                        Menampilkan data ke-<strong>{{ $ternak->firstItem() ?? 0 }}</strong> sampai <strong>{{ $ternak->lastItem() ?? 0 }}</strong> 
                                        dari Total <strong>{{ $ternak->total() }}</strong> Data
                                    </div>
                                    <div class="d-flex flex-wrap align-items-center justify-content-end mt-2 mt-md-0 w-100">
                                        <!-- Verification Actions Area -->
                                        @if(Auth::user()->user_type == 'B' || Auth::user()->user_type == 'C')
                                            @if($status_verifikasi['status_pengajuan'] == 0)
                                                <a href="{{ route('ajukan') }}" class="btn btn-primary btn-modern shadow-sm mr-2" style="background-color: #1e3a5f; border-color: #1e3a5f;"><i class="fas fa-paper-plane mr-1"></i> Ajukan Verifikasi Data</a>
                                            @elseif($status_verifikasi['status_pengajuan'] == 1)
                                                @if($status_verifikasi['status_verifikasi'] == null)
                                                    @if(!empty($status_verifikasi['id']))
                                                        <form action="{{ route('verifikasi.cancel', $status_verifikasi['id']) }}" method="POST" class="m-0 mr-2">
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-danger btn-modern shadow-sm" onclick="return confirm('Batalkan pengajuan data tahun ini?')">
                                                                <i class="fas fa-times mr-1"></i> Batalkan Pengajuan
                                                            </button>
                                                        </form>
                                                    @endif
                                                @elseif($status_verifikasi['status_verifikasi'] == 2)
                                                    <form action="{{ route('verifikasi.update', $status_verifikasi['id']) }}" method="POST" class="m-0 mr-2 d-flex align-items-center flex-wrap">
                                                        {{ csrf_field() }}
                                                        <span class="text-danger small mr-3 mb-2 mb-md-0"><b>Catatan Revisi:</b> {{ $status_verifikasi['catatan'] }}</span>
                                                        <button type="submit" class="btn btn-danger btn-modern shadow-sm"><i class="fas fa-paper-plane mr-1"></i> Ajukan Ulang Verifikasi</button>
                                                    </form>
                                                @endif
                                            @endif
                                        @endif
                                        
                                        <!-- Export & Pagination -->
                                        @if(!empty($_REQUEST['tahun']) OR !empty($_REQUEST['search']) OR !empty($_REQUEST['kab_kota']) OR !empty($_REQUEST['kecamatan']) OR !empty($_REQUEST['desa_kel']))
                                        <a href="{{ route('ternak.export').'?kab_kota='.(isset($_REQUEST['kab_kota'])?$_REQUEST['kab_kota']:'').'&kecamatan='.(isset($_REQUEST['kecamatan'])?$_REQUEST['kecamatan']:'').'&desa_kel='.(isset($_REQUEST['desa_kel'])?$_REQUEST['desa_kel']:'').'&search='.(isset($_REQUEST['search'])?$_REQUEST['search']:'') }}" class="btn btn-primary btn-modern shadow-sm mr-3" style="background-color: #1e3a5f; border-color: #1e3a5f;">
                                            <i class="fas fa-file-export"></i> Export
                                        </a>
                                        @else
                                        <a href="{{ route('ternak.export').'?kab_kota=&kecamatan=&desa_kel=&search=' }}" class="btn btn-primary btn-modern shadow-sm mr-3" style="background-color: #1e3a5f; border-color: #1e3a5f;">
                                            <i class="fas fa-file-export"></i> Export
                                        </a>
                                        @endif
                                        
                                        <div class="pagination-modern">
                                            {{ $ternak->appends(request()->query())->links() }}
                                        </div>
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

<div class="modal fade" id="modal-import-ternak">
<div class="modal-dialog modal-md">
    <div class="modal-content">
    <div class="modal-header">
        <h6>Import Data dari File Excel</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form action="{{ route('ternak.import') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
            <div>
                <a href="{{ asset('assets/dist/img/Template-Data-Ternak.xls') }}">Download Format File</a>
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
