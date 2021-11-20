@extends('layout.main')
@section('title', 'Tambah Stok Barang')
@section('container')

<div class="container">
    <div class="row">
        <div class="col-10 mb-3">
            <form action="/itemTransaksi/addTransaksi" method="post" class="mt-3">
                @csrf
                <input hidden type="text" class="form-control @error('bukti') is-invalid @enderror" id="bukti" name="bukti" value="TAMBAH" placeholder="Kode Barang"
                style="text-transform: uppercase">
                <div class="mb-3">
                  <label for="loc_site" class="form-label">Kode Lokasi</label>
                  <input type="text" class="form-control @error('loc_site') is-invalid @enderror" id="loc_site" name="loc_site" value="{{ old('loc_site')}}" placeholder="Kode Barang"
                  style="text-transform: uppercase">
                  @error('kodeBarang')
                  <div class="invalid-feedback">
                     {{$message}}
                  </div>
                  @enderror
                </div>
                <br>
                <div class="mb-3">
                    <label for="kodeBarang" class="form-label">Kode Barang</label>
                    <input type="text" class="form-control @error('id_kodebarang') is-invalid @enderror" id="id_kodebarang" name="id_kodebarang" value="{{ old('id_kodebarang')}}" placeholder="Kode Barang"
                    style="text-transform: uppercase">
                    @error('id_kodebarang')
                    <div class="invalid-feedback">
                       {{$message}}
                    </div>
                    @enderror
                  </div>
                  <br>
                <div class="form-group">
                    <label for="namaBarang" class="form-label">nama Barang</label>
                    <input type="text" class="form-control @error('namaBarang') is-invalid @enderror" id="namaBarang" name="namaBarang" value="{{ old('namaBarang')}}"
                    placeholder="nama Barang" style="text-transform: capitalize;">
                    @error('namaBarang')
                    <div class="invalid-feedback">
                       {{$message}}
                    </div>
                    @enderror
                </div>
                <br>
                <div class="form-group">
                    <label for="um" class="form-label">UM</label>
                    <input type="text" class="form-control @error('um') is-invalid @enderror" id="um" name="um" value="{{ old('um')}}">
                    @error('um')
                    <div class="invalid-feedback">
                       {{$message}}
                    </div>
                    @enderror
                </div>
                <br>
                <div class="mb-3">
                    <label for="qty" class="form-label">Qty</label>
                    <input type="text" class="form-control @error('qty') is-invalid @enderror" id="qty" name="qty" value="{{ old('qty')}}" placeholder="Kode Barang"
                    style="text-transform: uppercase">
                    @error('qty')
                    <div class="invalid-feedback">
                       {{$message}}
                    </div>
                    @enderror
                  </div>
                  <br>
                  <div class="mb-3">
                    <label for="tgl_masuk" class="form-label">Kode Lokasi</label>
                    <input type="date" class="form-control @error('tgl_masuk') is-invalid @enderror" id="tgl_masuk" name="tgl_masuk" value="{{ old('tgl_masuk')}}" placeholder="Kode Barang"
                    style="text-transform: uppercase">
                    @error('tgl_masuk')
                    <div class="invalid-feedback">
                       {{$message}}
                    </div>
                    @enderror
                  </div>
                <br>
                <div class="form-group">
                    <button type="submit" class="w-25 btn btn-primary" name="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection