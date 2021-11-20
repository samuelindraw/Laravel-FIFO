<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterLokasi extends Model
{
    protected $table = 'master_lokasis';
    protected $fillable = [
        'id',
        'kodeLokasi',
        'namaLokasi'
    ];
    public function Masterstok()
    {
        return $this->HasMany(Masterstok::class,'id_lokasi','id');
    }
    public function itemTransaksi()
    {
        return $this->HasMany(itemTransaksi::class,'id_lokasi','id');
    }
}
