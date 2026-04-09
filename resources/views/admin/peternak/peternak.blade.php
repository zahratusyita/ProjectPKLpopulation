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

    /* Badges */
    .badge-soft {
        padding: 0.5rem 0.8rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.9rem;
    }
    .badge-soft-primary { background-color: #ebf4ff; color: #3182ce; }
    .badge-soft-success { background-color: #f0fff4; color: #38a169; }
    .badge-soft-info { background-color: #e6fffa; color: #319795; }
    .badge-soft-warning { background-color: #fffff0; color: #d69e2e; }
    .badge-soft-danger { background-color: #fff5f5; color: #e53e3e; }
    .badge-soft-secondary { background-color: #edf2f7; color: #718096; }
</style>

<?php
    $no = 1;
?>
<div class="content content-wrapper border-0">
    <div class="content-header pt-4">
        <section class="container-fluid">
            <!-- Header Section with Buttons -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 mt-2">
                <div class="mb-3 mb-md-0">
                    <h1 class="m-0 font-weight-bold" style="color: #1e3a5f !important; font-size: 1.8rem;">Data Peternak</h1>
                    <p class="text-muted mb-0 mt-1" style="font-size: 0.95rem;">Kelola dan pantau data peternak yang terdaftar di sistem.</p>
                </div>
                
                <div class="d-flex flex-column align-items-md-end">
                    <div class="px-3 py-2 bg-white d-inline-flex align-items-center rounded-pill shadow-sm border border-light mb-3">
                        <i class="fas fa-calendar-alt mr-2" style="color:#1e3a5f; font-size: 1.2rem;"></i>
                        <strong style="color: #475569; font-size: 0.9rem;" class="mr-2">Tahun Data:</strong> 
                        <span class="badge px-3 py-1 rounded-pill" style="background-color:#1e3a5f; color:#fff; font-size:0.95rem; font-weight:700;">
                            {{ session()->get('tahun_data') ?? date('Y') }}
                        </span>
                    </div>
                    
                    <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                        @if(Auth::user()->user_type == 'C')
                        <a href="{{ route('peternak.form') }}" class="btn btn-primary btn-modern shadow-sm mr-2 mb-2" style="background-color: #1e3a5f; border-color: #1e3a5f;">
                            <i class="fas fa-plus mr-1"></i> Tambah Data
                        </a>
                        <button type="button" class="btn btn-outline-primary btn-modern shadow-sm mr-2 mb-2" data-toggle="modal" data-target="#modal-import-peternak" style="color: #1e3a5f; border-color: #1e3a5f;">
                            <i class="fas fa-file-import mr-1"></i> Import
                        </button>
                        @endif
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

            <div class="row">
                <div class="col-12">
                    <div class="card card-modern">
                        
                        <!-- Filter Section -->
                        <div class="card-header border-0 pb-0 pt-4">
                            <div class="filter-section">
                                <form class="form-row align-items-end" action="{{ route('peternak.search') }}" method="GET">
                                    {{csrf_field()}}
                                    <div class="col-md-3 mb-3 mb-md-0">
                                        <label class="text-dark font-weight-bold mb-2" for="kab_kota"><i class="fas fa-map-marker-alt mr-1"></i> Kabupaten/Kota</label>
                                        @if(Auth::user()->user_type == "A")
                                            <select name="kab_kota" id="kab_kota" class="form-control border-0 shadow-sm rounded" style="padding: 0.5rem;">
                                                <option value="">Semua Kab/Kota</option>
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
                                                <option value="">Semua Kecamatan</option>
                                            </select>
                                        @elseif(Auth::user()->user_type == "B" or Auth::user()->user_type == "C")
                                            <select name="kecamatan" id="kecamatan" class="form-control border-0 shadow-sm rounded" style="padding: 0.5rem;">
                                                <option value="">Semua Kecamatan</option>
                                                @foreach($kecamatan as $kc)
                                                <option value="{{ $kc->id }}">{{ $kc->nama_kecamatan }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                    <div class="col-md-2 mb-3 mb-md-0">
                                        <label class="text-dark font-weight-bold mb-2" for="desa_kel"><i class="fas fa-home mr-1"></i> Desa/Kelurahan</label>
                                        <select name="desa_kel" id="desa_kel" class="form-control border-0 shadow-sm rounded" style="padding: 0.5rem;">
                                            <option value="">Semua Desa/Kel</option>
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
                        
                        <!-- Table Content -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-modern text-nowrap align-middle">
                                <thead>
                                <tr>
                                    <th class="text-center" style="width: 5%">No.</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Tempat Lahir</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Jenis Kelamin</th>
                                    <th>No. Hp</th>
                                    <th>Desa/Kelurahan</th>
                                    <th>Alamat</th>
                                    <th>Pekerjaan</th>
                                    @if(Auth::user()->user_type == "C")
                                        <th class="text-center" style="width: 10%">Aksi</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                    @forelse($peternak as $p)
                                        @if($p)
                                            <tr>
                                                <td class="text-center font-weight-bold text-muted">{{ $no++ }}</td>
                                                <td class="font-weight-medium text-dark">{{ $p->nik }}</td>
                                                <td class="font-weight-bold text-dark" style="font-size: 1.05rem;">{{ $p->nama }}</td>
                                                <td class="font-weight-medium">{{ $p->tempat_lahir }}</td>
                                                <td class="text-nowrap">{{ date('d M Y', strtotime($p->tanggal_lahir)) }}</td>
                                                <td>
                                                    @if($p->jenis_kelamin == 1)
                                                        <span class="badge badge-soft badge-soft-primary"><i class="fas fa-mars mr-1"></i> Laki-laki</span>
                                                    @elseif($p->jenis_kelamin == 2)
                                                        <span class="badge badge-soft badge-soft-danger"><i class="fas fa-venus mr-1"></i> Perempuan</span>
                                                    @endif
                                                </td>
                                                <td>{{ $p->hp }}</td>
                                                <td>
                                                    @foreach($desa_kel as $dk)
                                                        @if($p->desa_kel_id == $dk->id)
                                                            {{ $dk->nama_desa_kel }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td style="white-space: normal; min-width: 250px;">{{ $p->alamat }}</td>
                                                <td>
                                                    <?php
                                                        if($p->pekerjaan == 1)      echo '<span class="badge badge-soft badge-soft-info">ASN/TNI/Polri</span>';
                                                        elseif($p->pekerjaan == 2)  echo '<span class="badge badge-soft badge-soft-success">Peternak</span>';
                                                        elseif($p->pekerjaan == 3)  echo '<span class="badge badge-soft badge-soft-warning">Petani</span>';
                                                        elseif($p->pekerjaan == 4)  echo '<span class="badge badge-soft badge-soft-secondary">Swasta</span>';
                                                        elseif($p->pekerjaan == 5)  echo '<span class="badge badge-soft badge-soft-secondary">Wiraswasta</span>';
                                                        elseif($p->pekerjaan == 6)  echo '<span class="badge badge-soft badge-soft-secondary">Pensiunan</span>';
                                                        elseif($p->pekerjaan == 7)  echo '<span class="badge badge-soft badge-soft-danger">Tidak Bekerja</span>';
                                                    ?>
                                                </td>
                                                @if(Auth::user()->user_type == "C")
                                                    <td class="text-center">
                                                        <div class="d-flex justify-content-center gap-1">
                                                            <a href="{{ route('peternak.edit', $p->id) }}" class="btn btn-warning btn-action-icon shadow-sm ml-1" title="Edit Data" style="width: 38px; height: 38px;">
                                                                <i class="fas fa-pen text-white" style="font-size: 1rem;"></i>
                                                            </a>
                                                            <form action="{{ route('peternak.delete', $p->id) }}" method="POST" class="d-inline">
                                                                {{ csrf_field() }}
                                                                <button type="submit" class="btn btn-danger btn-action-icon shadow-sm ml-1" onclick="return confirm('Apakah Anda yakin untuk menghapus data pendaftar ini?')" title="Hapus Data" style="width: 38px; height: 38px;">
                                                                    <i class="fas fa-trash-alt" style="font-size: 1rem;"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="11" class="text-center py-5">
                                                <div class="text-muted">
                                                    <i class="fas fa-box-open fa-3x mb-3" style="color: #cbd5e0;"></i>
                                                    <h5 class="text-dark">Data Peternak Kosong</h5>
                                                    <p>Belum ada data peternak yang ditambahkan atau ditemukan dengan kriteria tersebut.</p>
                                                    @if(Auth::user()->user_type == 'C')
                                                        <a href="{{ route('peternak.form') }}" class="btn btn-sm btn-primary btn-modern mt-2" style="background-color: #1e3a5f; border-color: #1e3a5f;">
                                                            <i class="fas fa-plus mr-1"></i> Tambah Data Sekarang
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="card-footer bg-white border-top-0 pt-4 pb-4 rounded-bottom">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                                <div class="text-muted mb-3 mb-md-0" style="font-size: 1rem;">
                                    <i class="fas fa-info-circle mr-1 text-primary"></i> 
                                    Menampilkan data ke-<strong>{{ $peternak->firstItem() ?? 0 }}</strong> sampai <strong>{{ $peternak->lastItem() ?? 0 }}</strong> 
                                    dari Total <strong>{{ $peternak->total() }}</strong> Data
                                </div>
                                <div class="d-flex flex-wrap align-items-center justify-content-end mt-2 mt-md-0">
                                    @if(!empty($_REQUEST['kab_kota']) OR !empty($_REQUEST['kecamatan']) OR !empty($_REQUEST['desa_kel']) OR !empty($_REQUEST['search']))
                                    <a href="{{ route('peternak.export').'?kab_kota='.$_REQUEST['kab_kota'].'&kecamatan='.$_REQUEST['kecamatan'].'&desa_kel='.$_REQUEST['desa_kel'].'&search='.$_REQUEST['search'] }}" class="btn btn-sm shadow-sm mr-3" style="background-color: #1e3a5f; border-color: #1e3a5f; color: #ffffff; width: 90px; text-align: center;">
                                        <i class="fas fa-file-export"></i> Export
                                    </a>
                                    @else
                                    <a href="{{ route('peternak.export').'?kab_kota=&kecamatan=&desa_kel=&search=' }}" class="btn btn-sm shadow-sm mr-3" style="background-color: #1e3a5f; border-color: #1e3a5f; color: #ffffff; width: 90px; text-align: center;">
                                        <i class="fas fa-file-export"></i> Export
                                    </a>
                                    @endif
                                    
                                    <div class="pagination-modern">
                                        {{ $peternak->appends(request()->query())->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Modal Import -->
<div class="modal fade" id="modal-import-peternak" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header bg-light border-bottom-0" style="border-radius: 16px 16px 0 0;">
                <h5 class="modal-title font-weight-bold text-dark"><i class="fas fa-file-excel mr-2 text-success"></i> Import Data Peternak</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('peternak.import') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body p-4">
                    <div class="alert alert-info border-0 rounded bg-light text-info mb-4">
                        <i class="fas fa-info-circle mr-2"></i> Pastikan format file sesuai dengan template yang disediakan.
                        <a href="{{ asset('assets/dist/img/Template-Data-Peternak.xls') }}" class="font-weight-bold text-info" style="text-decoration: underline;">Unduh Template Excel</a>
                    </div>
                    
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-muted small">Pilih File Excel (.xls / .xlsx)</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="file" id="customFile" required accept=".xls, .xlsx">
                            <label class="custom-file-label text-muted" for="customFile">Pilih file dari komputer Anda...</label>
                        </div>
                        <small class="form-text text-muted mt-2"><i class="fas fa-shield-alt mr-1"></i> File Anda diproses secara aman. Maks 2MB.</small>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top-0" style="border-radius: 0 0 16px 16px;">
                    <button type="button" class="btn btn-secondary btn-modern shadow-sm" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-modern shadow-sm" style="background-color: #1e3a5f; border-color: #1e3a5f;"><i class="fas fa-cloud-upload-alt mr-1"></i> Konfirmasi & Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script for custom file input text and interaction -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var fileInputs = document.querySelectorAll('.custom-file-input');
        fileInputs.forEach(function(input) {
            input.addEventListener('change', function(e) {
                var fileName = '';
                if(e.target.files && e.target.files.length > 0) {
                    fileName = e.target.files[0].name;
                }
                var nextSibling = e.target.nextElementSibling;
                if(nextSibling && fileName !== '') {
                    nextSibling.innerText = fileName;
                }
            });
        });
    });
</script>
@endsection