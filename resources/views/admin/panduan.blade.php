@extends('layouts.admin')

@section('content')
<div class="content content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Panduan Aplikasi</h5>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1.a.</td>
                                            <td>Panduan Penggunaan Aplikasi (Buku Panduan)</td>
                                            <td><a href="{{ asset('assets/dist/img/Buku-Panduan-Aplikasi-Populasi-Ternak-NTB-Tahun-2025-revisi.pdf') }}" class="btn btn-md btn-primary" target="_blank">Lihat</a></td>
                                        </tr>
                                        <tr>
                                            <td>1.b.</td>
                                            <td>Panduan Penggunaan Aplikasi (Video Tutorial)</td>
                                            <td><a href="https://youtu.be/kLO_N-OoO30" class="btn btn-md btn-primary" target="_blank">Lihat</a></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Kode Kabupaten/Kota</td>
                                            <td><a href="{{ asset('assets/dist/img/ID-kabupaten-kota.xls') }}" class="btn btn-md btn-primary">Lihat</a></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Kode Kecamatan</td>
                                            <td><a href="{{ asset('assets/dist/img/ID-kecamatan.xls') }}" class="btn btn-md btn-primary">Lihat</a></td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Kode Desa/Kelurahan</td>
                                            <td><a href="{{ asset('assets/dist/img/ID-desa-kelurahan.xls') }}" class="btn btn-md btn-primary">Lihat</a></td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>Kode Jenis Kelamin</td>
                                            <td><a href="{{ asset('assets/dist/img/kode-jenis-kelamin.xls') }}" class="btn btn-md btn-primary">Lihat</a></td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>Kode Pekerjaan</td>
                                            <td><a href="{{ asset('assets/dist/img/kode-pekerjaan.xls') }}" class="btn btn-md btn-primary">Lihat</a></td>
                                        </tr>
                                        <tr>
                                            <td>7</td>
                                            <td>Format/Template Import Data Peternak</td>
                                            <td><a href="{{ asset('assets/dist/img/Template-Data-Peternak.xls') }}" class="btn btn-md btn-primary">Lihat</a></td>
                                        </tr>
                                        <tr>
                                            <td>8</td>
                                            <td>Format/Template Import Data Ternak</td>
                                            <td><a href="{{ asset('assets/dist/img/Template-Data-Ternak.xls') }}" class="btn btn-md btn-primary">Lihat</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </div>
    </div>
    <!-- /.content-header -->
     
    <section class="content content-wrapper">
        
    </section>
</div>
@endsection