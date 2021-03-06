@extends('layout.main')
@section('title', 'Master stok')
@section('container')
    <h1 class="mb-3 text-center">{{ $title }}</h1>
    <div class="container">
        <div class="row">
            @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if (session()->has('delete'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('delete') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
           
            <div class="container-fluid">
                    <!-- DataTales Example -->
                    <div class="card">
                        <div class="card-body">
                            <form class="form-inline" action="/Masterstok/search" method="post">
                                <div class="form-group mb-2">
                                    @csrf
                                    <label for="kodeBarang">Kode Barang</label>
                                    <input type="text" class="form-control @error('kodeBarang') is-invalid @enderror" id="kodeBarang" name="kodeBarang" value="{{ old('kodeBarang') ?? $kodeBarang ?? '' }}" placeholder="kodeBarang"
                                    style="text-transform: uppercase">
                                    @error('kodeBarang')
                                    <div class="invalid-feedback">
                                       {{$message}}
                                    </div>
                                    @enderror
                                    <label for="kodeLokasi">kodeLokasi</label>
                                    <input type="text" class="form-control @error('kodeLokasi') is-invalid @enderror" id="kodeLokasi" name="kodeLokasi" value="{{ old('kodeLokasi') ?? $kodeLokasi ?? '' }}" placeholder="kodeLokasi"
                                    style="text-transform: uppercase">
                                    @error('kodeLokasi')
                                    <div class="invalid-feedback">
                                       {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group mx-sm-3 mb-2">
                                </div>
                                <button type="submit" id="submit" name="submit" class="btn btn-primary mb-2"><i
                                        class="fa fa-search fa-fw fa-xs"></i>Cari</button>
                            </form>
                            <a href="/Masterstok/export_excel" class="btn btn-success my-3" target="_blank">EXPORT EXCEL</a>
                            <a href="/Masterstok/cetak_pdf" class="btn btn-primary" target="_blank">CETAK PDF</a>
                        </div>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="d-none d-sm-table-cell">KODE LOKASI</th>
                                            <th class="d-none d-sm-table-cell">NAMA LOKASI</th>
                                            <th class="d-none d-sm-table-cell">KODE BARANG</th>
                                            <th class="d-none d-sm-table-cell">NAMA BARANG</th>
                                            <th class="d-none d-sm-table-cell">TGL MASUK</th>
                                            <th class="d-none d-sm-table-cell">QTY</th>
                                            <th class="d-none d-sm-table-cell">UM</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($masterstok as $stok )                                       
                                        <tr>
                                            <td>{{ $stok->MasterLokasi->kodeLokasi }}</td>
                                            <td>{{ optional($stok->MasterLokasi)->namaLokasi }}</td>
                                            <td>{{ $stok->MasterBarang->kodeBarang }}</td>
                                            <td>{{ optional($stok->MasterBarang)->namaBarang }}</td>
                                            <td>{{ \Carbon\Carbon::parse($stok->tgl_masuk)->format('d/m/Y H:i:s')}}</td>
                                            <td align="right">{{ $stok->qty }}</td>
                                            <td>{{ $stok->Masterum->um }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
        </div>
    </div>
@endsection
