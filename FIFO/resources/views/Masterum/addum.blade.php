@extends('layout.main')
@section('title', 'Tambah UM')
@section('container')

<div class="container">
    <div class="row">
        <div class="col-10 mb-3">
            <form action="/Masterum/addum" method="post" class="mt-3">
                @csrf
                <div class="mb-3">
                  <label for="um" class="form-label">UM</label>
                  <input type="text" class="form-control @error('um') is-invalid @enderror" id="um" name="um" value="{{ old('um')}}" placeholder="kode um"
                  style="text-transform: uppercase">
                  @error('um')
                  <div class="invalid-feedback">
                     {{$message}}
                  </div>
                  @enderror
                </div>
                <br>
                <div class="form-group">
                    <label for="name" class="form-label">Nama um</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name')}}"
                    placeholder="Name UM" style="text-transform: capitalize;">
                    @error('name')
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