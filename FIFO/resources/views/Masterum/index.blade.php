@extends('layout.main')
@section('title', 'Master UM')
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
            @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('error') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="container-fluid">
                    <!-- DataTales Example -->
                    <div class="card">
                        <div class="card-body">
                            <form class="form-inline" action="/Masterum/search" method="post">
                                <div class="form-group mb-2">
                                    @csrf
                                    <label for="um">um</label>
                                    <input type="text" class="form-control @error('um') is-invalid @enderror" id="um" name="kodeBarang" value="{{ old('um') ?? $kunci ?? '' }}" placeholder="um"
                                    style="text-transform: uppercase">
                                    @error('um')
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
                            <a href="/Masterum/addum" class="btn btn-primary bottom-buffer" id="btn-add-barang"
                                style="float:right;"><i class="fa fa-plus"></i> Tambah Barang </a>
                            <h6 class="m-0 font-weight-bold text-primary">Table Master Barang</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="d-none d-sm-table-cell">UM</th>
                                            <th class="d-none d-sm-table-cell">Nama</th>
                                            <th class="text-center" style="width: 15%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($masterum as $um )                                       
                                        <tr>
                                            <td>{{ $um->um }}</td>
                                            <td>{{ $um->name }}</td>
                                            <td class="text-center">
                                                <a href="/Masterum/{{ $um->id }}" title="edit"
                                                    class="btn btn-primary btn-sm">Edit</a>
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
