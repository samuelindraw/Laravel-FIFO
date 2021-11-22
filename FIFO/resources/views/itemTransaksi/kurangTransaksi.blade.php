@extends('layout.main')
@section('title', 'Tambah Stok Barang')
@section('container')

<div class="container">
    <div class="row">
        <div class="col-10 mb-3">
            <form action="/itemTransaksi/kurangTransaksi" method="post" class="mt-3">
                @csrf
                <input hidden type="text" class="form-control @error('bukti') is-invalid @enderror" id="bukti" name="bukti" value="KURANG" placeholder="Kode Barang"
                style="text-transform: uppercase">
                <div class="mb-3">
                  <label for="loc_site" class="form-label">Kode Lokasi</label>
                  <select class="form-control" name="id_lokasi" id="id_lokasi" required>
                      <option>Pilih Lokasi</option>
                    @foreach($lokasi as $item)
                      <option value="{{$item->id}}">{{$item->kodeLokasi}}</option>
                    @endforeach
                  </select>
                <br>
                <div class="form-group">
                  <label for="namaLokasi" id="namaLokasi1" class="form-label">Nama Lokasi</label>
                  <input type="text" class="form-control" id="namaLokasi" name="namaLokasi"
                  placeholder="nama Barang" style="text-transform: capitalize;" readonly>
                </div>
                <br>
                <div class="mb-3">
                    <label for="kodeBarang" class="form-label">Kode Barang</label>
                    <select class="form-control" name="id_kodebarang" id="id_kodebarang" required>
                        <option>Pilih Barang</option>
                      @foreach($barang as $item)
                        <option value="{{$item->id}}">{{$item->kodeBarang}}</option>
                      @endforeach
                    </select>
                  </div>
                {{-- AUTO INPUT DARI DROP DOWN BARANG --}}
                <div class="form-group">
                    <label for="namaBarang" id="namaBarang1" class="form-label">Nama Barang</label>
                    <input type="text" class="form-control" id="namaBarang" name="namaBarang"
                    placeholder="nama Barang" style="text-transform: capitalize;" readonly>
                </div>
                {{-- AUTO INPUT DARI DROP DOWN BARANG --}}
                <div class="form-group">
                    <label for="um" id="um1" class="form-label">UM</label>
                    <input type="text" class="form-control" id="um" name="um" readonly>
                </div>
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
                  <div class="mb-3">
                    <label for="tgl_masuk" class="form-label">Tanggal masuk</label>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
    $('#namaLokasi1').hide()
    $('#namaLokasi').hide()
    $('#namaBarang1').hide()
    $('#namaBarang').hide()
    $('#um1').hide()
    $('#um').hide()
    $('#id_lokasi').on('change', function() {
       var id_lokasi = $(this).val();
       if(id_lokasi) {
           $.ajax({
               url: '/getLokasi/'+id_lokasi,
               type: "GET",
               data : {"_token":"{{ csrf_token() }}"},
               dataType: "json",
               success:function(data)
               {
                 if(data){
                  $('#namaLokasi1').show()
                  $('#namaLokasi').show()
                   console.log(data['namaLokasi'])
                   $('#namaLokasi').val(data['namaLokasi']);
                }else{
                    $('#course').empty();
                }
             }
           });
       }else{
         $('#course').empty();
       }
    });
    $('#id_kodebarang').on('change', function() {
       var id_kodebarang = $(this).val();
       if(id_kodebarang) {
           $.ajax({
               url: '/getBarang/'+id_kodebarang,
               type: "GET",
               data : {"_token":"{{ csrf_token() }}"},
               dataType: "json",
               success:function(data)
               {
                 if(data){
                  $('#namaBarang1').show()
                  $('#namaBarang').show()
                  $('#um1').show()
                  $('#um').show()
                  $('#namaBarang').val(data['namaBarang']);
                  $('#um').val(data['um']);
                }else{
                    $('#course').empty();
                }
             }
           });
       }else{
         $('#course').empty();
       }
    });
    });
</script>
@endsection