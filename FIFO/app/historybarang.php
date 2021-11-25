<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class historybarang extends Model
{
    protected $fillable = [
        'id',
        'id_barang',
        'kodeBarang',
        'namaBarang',
        'id_um',
        'tanggal',
        'status'
    ];
}
