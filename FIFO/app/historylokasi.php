<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class historylokasi extends Model
{
    protected $fillable = [
        'id',
        'id_lokasi',
        'kodeLokasi',
        'namaLokasi',
        'tanggal',
        'status'
    ];
}
