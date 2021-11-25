@extends('layout.main')
@section('title', "Edit UM")
@section('container')

<div class="container">
    <div class="row">
        <div class="col-10 mb-3">
            <form action="/Masterum/editum" method="post" class="mt-3">
                 @method('patch')
                 @csrf
                <input type="hidden" class="form-control" name="id" value="{{ $masterum->id }}"
                style="text-transform: uppercase">
                <div class="mb-3">
                  <label for="um" class="form-label">Kode UM</label>
                  <input type="text" class="form-control @error('um') is-invalid @enderror" id="um" name="um" 
                  value="{{ $masterum->um }}" placeholder="Kode UM"
                  style="text-transform: uppercase">
                  @error('kodeBarang')
                  <div class="invalid-feedback">
                     {{$message}}
                  </div>
                  @enderror
                </div>
                <br>
                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                    value="{{ $masterum->name }}"
                    placeholder="Name UM " style="text-transform: capitalize;">
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