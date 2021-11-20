@extends('layout.main')
@section('title', 'Item Transaksi')
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
                            <form class="form-inline" action="/itemTransaksi/search" method="post">
                                <div class="form-group mb-2">
                                    @csrf
                                    <label for="kodeBarang">Bukti</label>
                                    <input type="text" class="form-control @error('bukti') is-invalid @enderror" id="bukti" name="bukti" value="{{ old('bukti') ?? $kunci ?? '' }}" placeholder="bukti"
                                    style="text-transform: uppercase">
                                    @error('bukti')
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
                        </div>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <a href="/itemTransaksi/addTransaksi" class="btn btn-primary bottom-buffer" id="btn-add-barang"
                                style="float:right;"><i class="fa fa-plus"></i> Tambah Barang </a>
                            <a href="/itemTransaksi/jualbarang" class="btn btn-primary bottom-buffer" id="btn-add-barang"
                            style="float:right;"><i class="fa fa-plus"></i> Jual Barang </a>
                            <h6 class="m-0 font-weight-bold text-primary">Table Master Barang</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="d-none d-sm-table-cell">Bukti</th>
                                            <th class="d-none d-sm-table-cell">Kode Lokasi</th>
                                            <th class="d-none d-sm-table-cell">Nama Lokasi</th>
                                            <th class="d-none d-sm-table-cell">Kode Barang</th>
                                            <th class="d-none d-sm-table-cell">Nama Barang</th>
                                            <th class="d-none d-sm-table-cell">Tgl_masuk</th>
                                            <th class="d-none d-sm-table-cell">qty</th>
                                            <th class="d-none d-sm-table-cell">um</th>
                                            <th class="text-center" style="width: 15%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($itemTransaksi as $trans )                                       
                                        <tr>
                                            <td>{{ $trans->bukti }}</td>
                                            <td>{{ $trans->loc_site }}</td>
                                            <td>{{ optional($trans->MasterLokasi)->namaLokasi }}</td>
                                            <td>{{ $trans->kodeBarang }}</td>
                                            <td>{{ optional($trans->MasterBarang)->namaBarang }}</td>
                                            <td>{{ $trans->tgl_masuk }}</td>
                                            <td>{{ $trans->qty }}</td>
                                            <td>{{ $trans->um }}</td>
                                            <td class="text-center">
                                                <a href="/itemTransaksi/{{ $trans->id }}" title="edit"
                                                    class="btn btn-primary btn-sm">Edit</a>
                                                <form method="POST" class="d-inline" onsubmit="return confirm('Move data to trash?')" action="{{route('destroyTransaksi', 
                                                [$trans->id])}}">
                                                    @csrf
                                                    <input type="hidden" value="DELETE" name="_method">
                                                    <input type="submit" value="Delete" class="btn btn-danger btn-sm">
                                                </form>
                                            </td>
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
