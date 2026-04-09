@extends('layouts.admin')

@section('content')
    <div class="content content-wrapper">
        <div class="content-header">
            <section class="container">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Update Data Mutasi {{ ucfirst($jenis) }}</h3>

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
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form action="{{ route('ternak.update', $ternak->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="peternak">Peternak</label>
                                                    <select class="form-control" name="peternak" id="peternak" required
                                                        disabled>
                                                        <option value="">Pilih Peternak</option>
                                                        @foreach($peternak as $pt)
                                                            <option value="{{ $pt->id }}" @if($pt->id == $ternak->peternak_id)
                                                            selected @endif>{{ $pt->nama }} ({{ $pt->nik }})</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="tanggal">Tanggal Mutasi</label>
                                                    <input type="date" class="form-control" name="tanggal" id="tanggal"
                                                        value="{{ $mutasi->tanggal }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="form-group">
                                                <h3>Sapi</h3>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="sapi_anak_jantan">Sapi Anak Jantan</label>
                                                        <input type="number" class="form-control" name="sapi_anak_jantan"
                                                            id="sapi_anak_jantan" value="{{ $ternak->sapi_anak_jantan }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="sapi_anak_betina">Sapi Anak Betina</label>
                                                        <input type="number" class="form-control" name="sapi_anak_betina"
                                                            id="sapi_anak_betina" value="{{ $ternak->sapi_anak_betina }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="sapi_muda_jantan">Sapi Muda Jantan</label>
                                                        <input type="number" class="form-control" name="sapi_muda_jantan"
                                                            id="sapi_muda_jantan" value="{{ $ternak->sapi_muda_jantan }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="sapi_muda_betina">Sapi Muda Betina</label>
                                                        <input type="number" class="form-control" name="sapi_muda_betina"
                                                            id="sapi_muda_betina" value="{{ $ternak->sapi_muda_betina }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="sapi_dewasa_jantan">Sapi Dewasa Jantan</label>
                                                        <input type="number" class="form-control" name="sapi_dewasa_jantan"
                                                            id="sapi_dewasa_jantan"
                                                            value="{{ $ternak->sapi_dewasa_jantan }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="sapi_dewasa_betina">Sapi Dewasa Betina</label>
                                                        <input type="number" class="form-control" name="sapi_dewasa_betina"
                                                            id="sapi_dewasa_betina"
                                                            value="{{ $ternak->sapi_dewasa_betina }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="form-group">
                                                <h3>Kerbau</h3>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="kerbau_anak_jantan">Kerbau Anak Jantan</label>
                                                        <input type="number" class="form-control" name="kerbau_anak_jantan"
                                                            id="kerbau_anak_jantan"
                                                            value="{{ $ternak->kerbau_anak_jantan }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="kerbau_anak_betina">Kerbau Anak Betina</label>
                                                        <input type="number" class="form-control" name="kerbau_anak_betina"
                                                            id="kerbau_anak_betina"
                                                            value="{{ $ternak->kerbau_anak_betina }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="kerbau_muda_jantan">Kerbau Muda Jantan</label>
                                                        <input type="number" class="form-control" name="kerbau_muda_jantan"
                                                            id="kerbau_muda_jantan"
                                                            value="{{ $ternak->kerbau_muda_jantan }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="kerbau_muda_betina">Kerbau Muda Betina</label>
                                                        <input type="number" class="form-control" name="kerbau_muda_betina"
                                                            id="kerbau_muda_betina"
                                                            value="{{ $ternak->kerbau_muda_betina }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="kerbau_dewasa_jantan">Kerbau Dewasa Jantan</label>
                                                        <input type="number" class="form-control"
                                                            name="kerbau_dewasa_jantan" id="kerbau_dewasa_jantan"
                                                            value="{{ $ternak->kerbau_dewasa_jantan }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="kerbau_dewasa_betina">Kerbau Dewasa Betina</label>
                                                        <input type="number" class="form-control"
                                                            name="kerbau_dewasa_betina" id="kerbau_dewasa_betina"
                                                            value="{{ $ternak->kerbau_dewasa_betina }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="form-group">
                                                <h3>Kuda</h3>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="kuda_anak_jantan">Kuda Anak Jantan</label>
                                                        <input type="number" class="form-control" name="kuda_anak_jantan"
                                                            id="kuda_anak_jantan" value="{{ $ternak->kuda_anak_jantan }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="kuda_anak_betina">Kuda Anak Betina</label>
                                                        <input type="number" class="form-control" name="kuda_anak_betina"
                                                            id="kuda_anak_betina" value="{{ $ternak->kuda_anak_betina }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="kuda_muda_jantan">Kuda Muda Jantan</label>
                                                        <input type="number" class="form-control" name="kuda_muda_jantan"
                                                            id="kuda_muda_jantan" value="{{ $ternak->kuda_muda_jantan }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="kuda_muda_betina">Kuda Muda Betina</label>
                                                        <input type="number" class="form-control" name="kuda_muda_betina"
                                                            id="kuda_muda_betina" value="{{ $ternak->kuda_muda_betina }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="kuda_dewasa_jantan">Kuda Dewasa Jantan</label>
                                                        <input type="number" class="form-control" name="kuda_dewasa_jantan"
                                                            id="kuda_dewasa_jantan"
                                                            value="{{ $ternak->kuda_dewasa_jantan }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="kuda_dewasa_betina">Kuda Dewasa Betina</label>
                                                        <input type="number" class="form-control" name="kuda_dewasa_betina"
                                                            id="kuda_dewasa_betina"
                                                            value="{{ $ternak->kuda_dewasa_betina }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="form-group">
                                                <h3>Kambing</h3>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="kambing_anak_jantan">Kambing Anak Jantan</label>
                                                        <input type="number" class="form-control" name="kambing_anak_jantan"
                                                            id="kambing_anak_jantan"
                                                            value="{{ $ternak->kambing_anak_jantan }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="kambing_anak_betina">Kambing Anak Betina</label>
                                                        <input type="number" class="form-control" name="kambing_anak_betina"
                                                            id="kambing_anak_betina"
                                                            value="{{ $ternak->kambing_anak_betina }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="kambing_muda_jantan">Kambing Muda Jantan</label>
                                                        <input type="number" class="form-control" name="kambing_muda_jantan"
                                                            id="kambing_muda_jantan"
                                                            value="{{ $ternak->kambing_muda_jantan }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="kambing_muda_betina">Kambing Muda Betina</label>
                                                        <input type="number" class="form-control" name="kambing_muda_betina"
                                                            id="kambing_muda_betina"
                                                            value="{{ $ternak->kambing_muda_betina }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="kambing_dewasa_jantan">Kambing Dewasa Jantan</label>
                                                        <input type="number" class="form-control"
                                                            name="kambing_dewasa_jantan" id="kambing_dewasa_jantan"
                                                            value="{{ $ternak->kambing_dewasa_jantan }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="kambing_dewasa_betina">Kambing Dewasa Betina</label>
                                                        <input type="number" class="form-control"
                                                            name="kambing_dewasa_betina" id="kambing_dewasa_betina"
                                                            value="{{ $ternak->kambing_dewasa_betina }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="form-group">
                                                <h3>Babi</h3>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="babi_anak_jantan">Babi Anak Jantan</label>
                                                        <input type="number" class="form-control" name="babi_anak_jantan"
                                                            id="babi_anak_jantan" value="{{ $ternak->babi_anak_jantan }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="babi_anak_betina">Babi Anak Betina</label>
                                                        <input type="number" class="form-control" name="babi_anak_betina"
                                                            id="babi_anak_betina" value="{{ $ternak->babi_anak_betina }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="babi_muda_jantan">Babi Muda Jantan</label>
                                                        <input type="number" class="form-control" name="babi_muda_jantan"
                                                            id="babi_muda_jantan" value="{{ $ternak->babi_muda_jantan }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="babi_muda_betina">Babi Muda Betina</label>
                                                        <input type="number" class="form-control" name="babi_muda_betina"
                                                            id="babi_muda_betina" value="{{ $ternak->babi_muda_betina }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="babi_dewasa_jantan">Babi Dewasa Jantan</label>
                                                        <input type="number" class="form-control" name="babi_dewasa_jantan"
                                                            id="babi_dewasa_jantan"
                                                            value="{{ $ternak->babi_dewasa_jantan }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="babi_dewasa_betina">Babi Dewasa Betina</label>
                                                        <input type="number" class="form-control" name="babi_dewasa_betina"
                                                            id="babi_dewasa_betina"
                                                            value="{{ $ternak->babi_dewasa_betina }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="form-group">
                                                <h3>Domba</h3>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="domba_anak_jantan">Domba Anak Jantan</label>
                                                        <input type="number" class="form-control" name="domba_anak_jantan"
                                                            id="domba_anak_jantan" value="{{ $ternak->domba_anak_jantan }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="domba_anak_betina">Domba Anak Betina</label>
                                                        <input type="number" class="form-control" name="domba_anak_betina"
                                                            id="domba_anak_betina" value="{{ $ternak->domba_anak_betina }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="domba_muda_jantan">Domba Muda Jantan</label>
                                                        <input type="number" class="form-control" name="domba_muda_jantan"
                                                            id="domba_muda_jantan" value="{{ $ternak->domba_muda_jantan }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="domba_muda_betina">Domba Muda Betina</label>
                                                        <input type="number" class="form-control" name="domba_muda_betina"
                                                            id="domba_muda_betina" value="{{ $ternak->domba_muda_betina }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="domba_dewasa_jantan">Domba Dewasa Jantan</label>
                                                        <input type="number" class="form-control" name="domba_dewasa_jantan"
                                                            id="domba_dewasa_jantan"
                                                            value="{{ $ternak->domba_dewasa_jantan }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="domba_dewasa_betina">Domba Dewasa Betina</label>
                                                        <input type="number" class="form-control" name="domba_dewasa_betina"
                                                            id="domba_dewasa_betina"
                                                            value="{{ $ternak->domba_dewasa_betina }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="form-group">
                                                <h3>Unggas</h3>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="ayam_ras">Ayam Ras</label>
                                                        <input type="number" class="form-control" name="ayam_ras"
                                                            id="ayam_ras" value="{{ $ternak->ayam_ras }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="ayam_buras">Ayam Buras</label>
                                                        <input type="number" class="form-control" name="ayam_buras"
                                                            id="ayam_buras" value="{{ $ternak->ayam_buras }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="ayam_petelur">Ayam Petelur</label>
                                                        <input type="number" class="form-control" name="ayam_petelur"
                                                            id="ayam_petelur" value="{{ $ternak->ayam_petelur }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="itik">Itik</label>
                                                        <input type="number" class="form-control" name="itik" id="itik"
                                                            value="{{ $ternak->itik }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="puyuh">Puyuh</label>
                                                        <input type="number" class="form-control" name="puyuh" id="puyuh"
                                                            value="{{ $ternak->puyuh }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="form-group">
                                                    <h3>Keterangan</h3>
                                                </div>
                                                <div class="form-group">
                                                    <label for="keterangan">Keterangan atas data yang di-input</label>
                                                    <textarea class="form-control" name="keterangan" id="keterangan"
                                                        placeholder="Penjelasan terkait data yang di-input (misalnya terjadi kematian ternak atau ternak dijual)">{{ $ternak->keterangan }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection