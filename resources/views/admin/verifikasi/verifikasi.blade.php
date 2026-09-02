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
</style>

<?php
    $no = 1;
?>
<div class="content content-wrapper border-0">
    <div class="content-header pt-4">
        <section class="container-fluid">
            <!-- Header Section -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 mt-2">
                <div class="mb-3 mb-md-0">
                    <h1 class="m-0 font-weight-bold" style="color: #1e3a5f !important; font-size: 1.8rem;">Verifikasi Data</h1>
                    <p class="text-muted mb-0 mt-1" style="font-size: 0.95rem;">Pantau dan kelola riwayat verifikasi data.</p>
                </div>
                
                <div class="d-flex flex-column align-items-md-end">
                    <div class="px-3 py-2 bg-white d-inline-flex align-items-center rounded-pill shadow-sm border border-light">
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
                    <div class="card card-modern">
                        
                        <!-- Filter Section -->
                        <div class="card-header border-0 pb-0 pt-4">
                            <div class="filter-section">
                                <form class="form-row align-items-end" action="{{ route('verifikasi.search') }}" method="GET">
                                    {{ csrf_field() }}
                                    <div class="col-md-5 mb-3 mb-md-0">
                                        <label class="text-dark font-weight-bold mb-2"><i class="fas fa-map-marker-alt mr-1"></i> Kabupaten/Kota</label>
                                        @if(Auth::user()->user_type == "A")
                                            <select name="kab_kota" id="kab_kota" class="form-control border-0 shadow-sm rounded" style="padding: 0.5rem;">
                                                <option value="">Pilih Kabupaten/Kota</option>
                                                @foreach($kab_kota as $kk)
                                                <option value="{{$kk->id}}">{{$kk->nama_kab_kota}}</option>
                                                @endforeach
                                            </select>
                                        @elseif(Auth::user()->user_type == "B")
                                            <select name="kab_kota" id="kab_kota" class="form-control border-0 shadow-sm rounded" style="padding: 0.5rem;">
                                                @foreach($kab_kota as $kk)
                                                <option value="{{$kk->id}}">{{$kk->nama_kab_kota}}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                    @if(Auth::user()->user_type == "B")
                                    <div class="col-md-5 mb-3 mb-md-0">
                                        <label class="text-dark font-weight-bold mb-2"><i class="fas fa-map mr-1"></i> Kecamatan</label>
                                        <select name="kecamatan" id="kecamatan" class="form-control border-0 shadow-sm rounded" style="padding: 0.5rem;">
                                            <option value="">Pilih Kecamatan</option>
                                            @foreach($kecamatan as $kc)
                                            <option value="{{ $kc->id }}">{{ $kc->nama_kecamatan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif
                                    <div class="col-md-2 mb-3 mb-md-0">
                                        <button type="submit" class="btn btn-light btn-block btn-modern shadow-sm font-weight-bold" style="background-color: #ffffff; border-color: #cbd5e1; color: #334155; padding: 0.45rem; font-size: 0.9rem;">
                                            <i class="fas fa-search"></i> Cari
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body table-responsive p-0">
                        @if(Auth::user()->user_type == 'A')
                            {{-- ========================================================= --}}
                            {{-- TAMPILAN ADMIN A (PROVINSI) : PENGAJUAN REGIONAL KABUPATEN --}}
                            {{-- ========================================================= --}}
                            <table class="table table-modern text-nowrap align-middle">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tahun</th>
                                    <th>Kabupaten/Kota</th>
                                    <th>Status Pengajuan</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Status Verifikasi</th>
                                    <th>Tanggal Verifikasi</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($verifikasi as $v)
                                        @if($v != '')
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $v->tahun }}</td>
                                                @foreach($kab_kota as $kk)
                                                    @if($v->daerah == $kk->id)
                                                    <td>{{ $kk->nama_kab_kota }}</td>
                                                    @endif
                                                @endforeach

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
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        @elseif(Auth::user()->user_type == 'B')
                            {{-- ========================================================= --}}
                            {{-- TAMPILAN ADMIN B (KABUPATEN) : RIWAYAT PER-TERNAK        --}}
                            {{-- ========================================================= --}}
                            <table class="table table-modern text-nowrap align-middle">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tahun</th>
                                    <th>Peternak (NIK)</th>
                                    <th>Kecamatan</th>
                                    <th>Status Pengajuan</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Status Verifikasi</th>
                                    <th>Tanggal Verifikasi</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @forelse($ternak_pending as $v)
                                        @php $status = (int) ($v->status_pengajuan ?? 0); @endphp
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $v->tahun }}</td>
                                            <td>{{ $v->nama }}<br><small class="text-muted">{{ $v->nik }}</small></td>
                                            <td>
                                                @foreach($kecamatan as $kc)
                                                    @if($v->kecamatan_id == $kc->id)
                                                        {{ $kc->nama_kecamatan }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @if($status === 0)
                                                    <span class="badge badge-secondary">Draft</span>
                                                @elseif($status === 1)
                                                    <span class="badge badge-warning">Sudah diajukan</span>
                                                @elseif($status === 2)
                                                    <span class="badge badge-success">Sudah diajukan</span>
                                                @else
                                                    <span class="badge badge-danger">Perlu diajukan ulang</span>
                                                @endif
                                            </td>
                                            <td>{{ $status === 0 ? '-' : $v->updated_at }}</td>
                                            <td>
                                                @if($status === 0)
                                                    <span class="text-muted">Belum diajukan</span>
                                                @elseif($status === 1)
                                                    <span class="badge badge-warning">Menunggu verifikasi</span>
                                                @elseif($status === 2)
                                                    <span class="badge badge-success">Sudah diverifikasi</span>
                                                @else
                                                    <span class="badge badge-danger">Ditolak / Revisi</span>
                                                @endif
                                            </td>
                                            <td>{{ in_array($status, [2, 3], true) ? $v->updated_at : '-' }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($status === 1)
                                                        <button type="button" class="btn btn-sm btn-primary btn-modern shadow-sm" data-toggle="modal" data-target="#modal-kabupaten-{{ $v->id }}">
                                                            <i class="fas fa-check mr-1"></i> Verifikasi
                                                        </button>
                                                    @elseif(!empty($v->keterangan))
                                                        <button type="button" class="btn btn-sm btn-light btn-modern shadow-sm" data-toggle="modal" data-target="#modal-detail-{{ $v->id }}">
                                                            <i class="fas fa-eye mr-1"></i> Detail
                                                        </button>
                                                    @else
                                                        <span class="text-muted">Selesai</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-5">
                                                <div class="text-muted">
                                                    <i class="fas fa-history fa-3x mb-3" style="opacity: 0.5;"></i>
                                                    <h5>Belum ada data pada tahun aktif</h5>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        @endif
                        </div>
                        
                        <!-- /.card-body -->
                        <div class="card-footer bg-white border-top-0 pt-4 pb-4 rounded-bottom">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                                @if(Auth::user()->user_type == 'B')
                                    <div class="text-muted mb-3 mb-md-0" style="font-size: 1rem;">
                                        <i class="fas fa-info-circle mr-1 text-primary"></i> 
                                        Menampilkan data ke-<strong>{{ $ternak_pending->firstItem() ?? 0 }}</strong> sampai <strong>{{ $ternak_pending->lastItem() ?? 0 }}</strong> 
                                        dari Total <strong>{{ $ternak_pending->total() }}</strong> Data
                                    </div>
                                    <div class="d-flex flex-wrap align-items-center justify-content-end mt-2 mt-md-0 w-100 pagination-modern">
                                        @if(($pending_count ?? 0) > 0)
                                            <form action="{{ route('verifikasi.all') }}" method="POST" class="mr-3 m-0">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-modern shadow-sm" onclick="return confirm('Verifikasi SEMUA data yang sedang menunggu?')">
                                                    <i class="fas fa-check-double mr-1"></i> Verifikasi Semua
                                                </button>
                                            </form>
                                        @endif
                                        {{ $ternak_pending->links() }}
                                    </div>
                                @elseif(Auth::user()->user_type == 'A')
                                    <div class="text-muted mb-3 mb-md-0" style="font-size: 1rem;">
                                        <i class="fas fa-info-circle mr-1 text-primary"></i> 
                                        Menampilkan data ke-<strong>{{ $verifikasi->firstItem() ?? 0 }}</strong> sampai <strong>{{ $verifikasi->lastItem() ?? 0 }}</strong> 
                                        dari Total <strong>{{ $verifikasi->total() }}</strong> Data Kabupaten
                                    </div>
                                    <div class="d-flex flex-wrap align-items-center justify-content-end mt-2 mt-md-0 pagination-modern">
                                        {{ $verifikasi->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </section>
    </div>
</div>

@if(Auth::user()->user_type == 'A')
    {{-- Modal Verifikasi untuk Admin A --}}
    @foreach($verifikasi as $vk)
    <div class="modal fade" id="modal-sm-{{ $vk->id }}">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
        <div class="modal-header">
            <h6 class="modal-title">Verifikasi ({{ $vk->nama_kab_kota }} - {{ $vk->tahun }})</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('verifikasi.update', $vk->id) }}" method="POST">
            {{ csrf_field() }}
                <div>
                    <textarea class="form-control" name="catatan" id="catatan" placeholder="Catatan (wajib jika ditolak)&hellip;"></textarea>
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
@elseif(Auth::user()->user_type == 'B')
    {{-- Modal Verifikasi untuk Admin B, mengikuti pola modal Admin Provinsi --}}
    @foreach($ternak_pending as $vk)
    @php $statusModal = (int) ($vk->status_pengajuan ?? 0); @endphp
    @if($statusModal === 1)
    <div class="modal fade" id="modal-kabupaten-{{ $vk->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Verifikasi Data Kecamatan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form method="POST">
            @csrf
            <div class="modal-body">
                <p class="mb-1"><strong>{{ $vk->nama }}</strong> ({{ $vk->nik }})</p>
                <p class="text-muted">Tahun {{ $vk->tahun }} - data diajukan oleh Kecamatan.</p>
                <div class="form-group">
                    <label for="catatan-{{ $vk->id }}">Catatan</label>
                    <textarea class="form-control" name="catatan" id="catatan-{{ $vk->id }}" rows="4" placeholder="Opsional saat menerima, wajib saat menolak"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                <button type="submit" formaction="{{ route('verifikasi.reject', $vk->id) }}" class="btn btn-danger" onclick="var note=document.getElementById('catatan-{{ $vk->id }}'); if(!note.value.trim()){note.setCustomValidity('Catatan wajib diisi saat menolak.'); note.reportValidity(); return false;} note.setCustomValidity('');">
                    <i class="fas fa-times mr-1"></i> Tolak
                </button>
                <button type="submit" formaction="{{ route('verifikasi.single', $vk->id) }}" class="btn btn-success">
                    <i class="fas fa-check mr-1"></i> Verifikasi / Terima
                </button>
            </div>
        </form>
        </div>
    </div>
    </div>
    @elseif(!empty($vk->keterangan))
    <div class="modal fade" id="modal-detail-{{ $vk->id }}">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Catatan Verifikasi</h6>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <p class="mb-2"><strong>{{ $vk->nama }}</strong> ({{ $vk->nik }})</p>
                    <p class="mb-0">{{ $vk->keterangan }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach
@endif
@endsection
