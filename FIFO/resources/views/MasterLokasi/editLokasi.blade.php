@extends('layout.main')
@section('title', "Edit Lokasi")
@section('container')

<div class="container">
    <div class="row">
        <div class="col-10 mb-3">
            <form action="/MasterLokasi/editLokasi" method="post" class="mt-3">
                 @method('patch')
                 @csrf
                <input type="hidden" class="form-control" name="id" value="{{ $masterLokasi->id }}"
                style="text-transform: uppercase">
                <div class="mb-3">
                  <label for="kodeLokasi" class="form-label">Kode Lokasi</label>
                  <input type="text" class="form-control @error('kodeLokasi') is-invalid @enderror" id="kodeLokasi" name="kodeLokasi" 
                  value="{{ $masterLokasi->kodeLokasi }}" placeholder="kode Lokasi"
                  style="text-transform: uppercase">
                  @error('kodeLokasi')
                  <div class="invalid-feedback">
                     {{$message}}
                  </div>
                  @enderror
                </div>
                <br>
                <div class="form-group">
                    <label for="namaLokasi" class="form-label">Nama Lokasi</label>
                    <input type="text" class="form-control @error('namaLokasi') is-invalid @enderror" id="namaLokasi" name="namaLokasi" 
                    value="{{ $masterLokasi->namaLokasi }}"
                    placeholder="nama Lokasi" style="text-transform: capitalize;">
                    @error('namaLokasi')
                    <div class="invalid-feedback">
                       {{$message}}
                    </div>
                    @enderror
                </div>
                <br>
                <br>
                <div class="form-group">
                    <button type="submit" class="w-25 btn btn-primary" name="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection