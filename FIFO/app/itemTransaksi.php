<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class itemTransaksi extends Model
{
    protected $fillable = [
        'id',
        'bukti',
        'id_lokasi',
        'id_kodebarang',
        'namaBarang',
        'id_um',
        'qty',
        'tgl_masuk'
    ];
    public function MasterBarang()
    {
        return $this->belongsTo(MasterBarang::class,'id_kodebarang','id');
    }
    public function MasterLokasi()
    {
        return $this->belongsTo(MasterLokasi::class,'id_lokasi','id');
    }
    public function Masterum()
    {
        return $this->belongsTo(Masterum::class,'id_um','id');
    }
}
