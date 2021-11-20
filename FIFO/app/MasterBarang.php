<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterBarang extends Model
{
    
    protected $fillable = [
        'id',
        'kodeBarang',
        'namaBarang',
        'um'
    ];

    public function Masterstok()
    {
        return $this->HasMany(Masterstok::class,'id_kodebarang','id');
    }
    public function itemTransaksi()
    {
        return $this->HasMany(itemTransaksi::class,'id_kodebarang','id');
    }
}
