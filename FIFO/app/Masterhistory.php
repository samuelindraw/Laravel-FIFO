<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Masterhistory extends Model
{
    // protected $table = 'Masterhistory';
    protected $fillable = [
        'id',
        'bukti',
        'tgl_trans',
        'jam',
        'id_lokasi',
        'id_kodebarang',
        'qty',
        'tgl_masuk',
        'program',
        'userid'
    ];
    public function MasterBarang()
    {
        return $this->belongsTo(MasterBarang::class,'id_kodebarang','id');
    }
    public function MasterLokasi()
    {
        return $this->belongsTo(MasterLokasi::class,'id_lokasi','id');
    }
}
