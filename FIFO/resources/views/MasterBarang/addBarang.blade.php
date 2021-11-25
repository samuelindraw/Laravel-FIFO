@extends('layout.main')
@section('title', 'Tambah Barang')
@section('container')

<div class="container">
    <div class="row">
        <div class="col-10 mb-3">
            <form action="/MasterBarang/addBarang" method="post" class="mt-3">
                @csrf
                <div class="mb-3">
                  <label for="kodeBarang" class="form-label">Kode Barang</label>
                  <input type="text" class="form-control @error('kodeBarang') is-invalid @enderror" id="kodeBarang" name="kodeBarang" value="{{ old('kodeBarang')}}" placeholder="Kode Barang"
                  style="text-transform: uppercase">
                  @error('kodeBarang')
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
                {{-- <div class="mb-3">
                    <label for="id_um" class="form-label">Unit Measurement</label>
                    <select class="form-control" name="id_um" id="id_um" required>
                        <option>Pilih UM</option>
                      @foreach($masterum as $item)
                        <option value="{{$item->id}}">{{$item->um}}</option>
                      @endforeach
                    </select>
                </div> --}}
                <br>
                <div class="mb-3">
                    <label for="id_um" class="form-label">Unit Measurement</label>
                    <select class="form-control" name="id_um" id="id_um" required>
                        <option>Pilih UM</option>
                      @foreach($masterum as $item)
                        {{-- <option value="{{$item->id}}">{{$item->kodeBarang}}</option> --}}
                        <option value="{{$item->id}}" @isset($id_um) @if ($id_um == $item->id)
                        selected
                        @endif
                    @endisset>{{ $item->um }}</option>
                      @endforeach
                    </select>
                  </div>
                <div class="form-group">
                    <button type="submit" class="w-25 btn btn-primary" name="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection