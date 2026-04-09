@extends('layouts.admin')

@section('content')
@php
    $isKelahiran = $jenis === 'kelahiran';
    $ageLabels = ['anak' => 'Anak', 'muda' => 'Muda', 'dewasa' => 'Dewasa'];
@endphp
<div class="content content-wrapper">
    <div class="content-header">
        <section class="container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Update Data Mutasi {{ ucfirst($jenis) }}</h3>
                            </div>
                            <form action="{{ route('mutasi.update', ['jenis' => $jenis, 'id' => $mutasi->id]) }}" method="POST">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="peternak">Peternak</label>
                                                <select class="form-control" name="peternak" id="peternak" required>
                                                    <option value="">Pilih Peternak</option>
                                                    @foreach($peternak as $pt)
                                                        <option value="{{ $pt->id }}" @selected(old('peternak', $mutasi->peternak_id) == $pt->id)>
                                                            {{ $pt->nama }} ({{ $pt->nik }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div id="lokasi" class="mt-2"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="tanggal">Tanggal Mutasi</label>
                                                <input type="date" class="form-control" name="tanggal" id="tanggal" value="{{ old('tanggal', $mutasi->tanggal) }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    @if($isKelahiran)
                                        <div class="alert alert-info">
                                            Untuk mutasi kelahiran, input cukup jumlah jantan dan betina per jenis ternak. Data akan dicatat sebagai ternak anak.
                                        </div>

                                        @foreach($mamalia as $field => $label)
                                            <div class="mb-3">
                                                <h5>{{ $label }}</h5>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="{{ $field }}_jantan">{{ $label }} Jantan</label>
                                                            <input type="number" min="0" class="form-control" name="{{ $field }}_jantan" id="{{ $field }}_jantan" value="{{ old($field.'_jantan', data_get($mutasi, $field.'_anak_jantan', 0)) }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="{{ $field }}_betina">{{ $label }} Betina</label>
                                                            <input type="number" min="0" class="form-control" name="{{ $field }}_betina" id="{{ $field }}_betina" value="{{ old($field.'_betina', data_get($mutasi, $field.'_anak_betina', 0)) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        @foreach($mamalia as $field => $label)
                                            <div class="mb-3">
                                                <h5>{{ $label }}</h5>
                                                @foreach($ageLabels as $ageKey => $ageLabel)
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="{{ $field }}_{{ $ageKey }}_jantan">{{ $label }} {{ $ageLabel }} Jantan</label>
                                                                <input type="number" min="0" class="form-control" name="{{ $field }}_{{ $ageKey }}_jantan" id="{{ $field }}_{{ $ageKey }}_jantan" value="{{ old($field.'_'.$ageKey.'_jantan', data_get($mutasi, $field.'_'.$ageKey.'_jantan', 0)) }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="{{ $field }}_{{ $ageKey }}_betina">{{ $label }} {{ $ageLabel }} Betina</label>
                                                                <input type="number" min="0" class="form-control" name="{{ $field }}_{{ $ageKey }}_betina" id="{{ $field }}_{{ $ageKey }}_betina" value="{{ old($field.'_'.$ageKey.'_betina', data_get($mutasi, $field.'_'.$ageKey.'_betina', 0)) }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    @endif

                                    <div class="mb-3">
                                        <h5>Unggas</h5>
                                        <div class="row">
                                            @foreach($unggas as $field => $label)
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="{{ $field }}">{{ $label }}</label>
                                                        <input type="number" min="0" class="form-control" name="{{ $field }}" id="{{ $field }}" value="{{ old($field, data_get($mutasi, $field, 0)) }}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="keterangan">Keterangan</label>
                                        <textarea class="form-control" name="keterangan" id="keterangan" placeholder="Penjelasan tambahan bila diperlukan">{{ old('keterangan', $mutasi->keterangan) }}</textarea>
                                    </div>
                                </div>

                                <div class="card-footer d-flex justify-content-between flex-wrap" style="gap: 0.75rem;">
                                    <a href="{{ route('mutasi.index', ['jenis' => $jenis]) }}" class="btn btn-secondary">
                                        Batalkan
                                    </a>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
