@extends('layout.main')
@section('title', "Edit Barang")
@section('container')

<div class="container">
    <div class="row">
        <div class="col-10 mb-3">
            <form action="/MasterBarang/editBarang" method="post" class="mt-3">
                 @method('patch')
                 @csrf
                <input type="hidden" class="form-control" name="id" value="{{ $masterBarang->id }}"
                style="text-transform: uppercase">
                <div class="mb-3">
                  <label for="kodeBarang" class="form-label">Kode Barang</label>
                  <input type="text" class="form-control @error('kodeBarang') is-invalid @enderror" id="kodeBarang" name="kodeBarang" 
                  value="{{ $masterBarang->kodeBarang }}" placeholder="Kode Barang"
                  style="text-transform: uppercase">
                  @error('kodeBarang')
                  <div class="invalid-feedback">
                     {{$message}}
                  </div>
                  @enderror
                </div>
                <br>
                <div class="form-group">
                    <label for="namaBarang" class="form-label">Nama Barang</label>
                    <input type="text" class="form-control @error('namaBarang') is-invalid @enderror" id="namaBarang" name="namaBarang" 
                    value="{{ $masterBarang->namaBarang }}"
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
                    <input type="text" class="form-control @error('um') is-invalid @enderror" id="um" name="um" 
                    value="{{ $masterBarang->um }}">
                    @error('um')
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