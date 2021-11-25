@extends('layout.main')
@section('title', 'Master History')
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
                        <form class="form-inline" action="/Masterhistory/search" method="post">
                            <div class="form-group mb-2">
                                @csrf
                                <label for="kodeBarang">Kode Barang</label>
                                <input type="text" class="form-control @error('kodeBarang') is-invalid @enderror"
                                    id="kodeBarang" name="kodeBarang"
                                    value="{{ old('kodeBarang') ?? ($kodeBarang ?? '') }}" placeholder="kodeBarang"
                                    style="text-transform: uppercase">
                                @error('kodeBarang')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <br>
                                <label for="bukti">Bukti</label>
                                <input type="text" class="form-control @error('bukti') is-invalid @enderror" id="bukti"
                                    name="bukti" value="{{ old('bukti') ?? ($bukti ?? '') }}" placeholder="bukti"
                                    style="text-transform: uppercase">
                                @error('bukti')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <br>
                                <label for="tgl_trans">Tanggal trans</label>
                                <input type="text" class="form-control @error('tgl_trans') is-invalid @enderror"
                                    id="datepicker" name="tgl_trans" value="{{ old('tgl_trans') ?? ($tgl_trans ?? '') }}"
                                    placeholder="DD/MM/YYYY" style="text-transform: uppercase">
                                @error('tgl_trans')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <br>
                                <label for="kodeLokasi">Kode Lokasi</label>
                                <input type="text" class="form-control @error('kodeLokasi') is-invalid @enderror"
                                    id="kodeLokasi" name="kodeLokasi"
                                    value="{{ old('kodeLokasi') ?? ($kodeLokasi ?? '') }}" placeholder="kodeLokasi"
                                    style="text-transform: uppercase">
                                @error('kodeLokasi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <br>
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                            </div>
                            <button type="submit" id="submit" name="submit" class="btn btn-primary mb-2"><i
                                    class="fa fa-search fa-fw fa-xs"></i>Cari</button>
                        </form>
                        <a href="/Masterhistory/export_excel" class="btn btn-success my-3" target="_blank">EXPORT EXCEL</a>
                        <a href="/Masterhistory/cetak_pdf" class="btn btn-primary" target="_blank">CETAK PDF</a>
                    </div>
                </div>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Table Master History</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    {{-- {{ \Carbon\Carbon::parse($user->from_date)->format('d/m/Y')}} --}}
                                    <tr>
                                        <th class="d-none d-sm-table-cell">BUKTI</th>
                                        <th class="d-none d-sm-table-cell">TGL TRN</th>
                                        <th class="d-none d-sm-table-cell">JAM</th>
                                        <th class="d-none d-sm-table-cell">KODE LOKASI</th>
                                        <th class="d-none d-sm-table-cell">NAMA LOKASI</th>
                                        <th class="d-none d-sm-table-cell">KODE BARANG</th>
                                        <th class="d-none d-sm-table-cell">NAMA BARANG</th>
                                        <th class="d-none d-sm-table-cell">TGL MASUK</th>
                                        <th class="d-none d-sm-table-cell">QTY</th>
                                        <th class="d-none d-sm-table-cell">PROGRAM</th>
                                        <th class="d-none d-sm-table-cell">USERID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($masterhistory as $his)
                                        <tr>
                                            <td>{{ $his->bukti }}</td>
                                            <td>{{ \Carbon\Carbon::parse($his->tgl_trans)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($his->tgl_masuk)->format('H:i') }}</td>
                                            <td>{{ $his->MasterLokasi->kodeLokasi }}</td>
                                            <td>{{ optional($his->MasterLokasi)->namaLokasi }}</td>
                                            <td>{{ $his->MasterBarang->kodeBarang }}</td>
                                            <td>{{ optional($his->MasterBarang)->namaBarang }}</td>
                                            <td>{{ \Carbon\Carbon::parse($his->tgl_masuk)->format('d/m/Y') }}</td>
                                            <td align="right">{{ $his->qty }}</td>
                                            <td>{{ $his->program }}</td>
                                            <td>{{ $his->userid }}</td>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
    <script>
        $(document).ready(function() {
        $('#datepicker').datetimepicker({
        useCurrent: true,
        format: 'DD/MM/YYYY',
        widgetPositioning: {
            horizontal: 'auto',
            vertical: 'auto'
        }
        });
        });
    </script>
@endsection
