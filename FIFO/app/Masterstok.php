<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Masterstok extends Model
{
    protected $table = 'master_stocks';
    protected $fillable = [
        'id',
        'id_lokasi',
        'id_kodebarang',
        'qty',
        'id_um',
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
