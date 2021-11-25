<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Masterum extends Model
{
    protected $fillable = [
        'id',
        'um',
        'name',
    ];
    public function Masterstok()
    {
        return $this->HasMany(Masterstok::class,'id_um','id');
    }
    public function itemTransaksi()
    {
        return $this->HasMany(itemTransaksi::class,'id_um','id');
    }
    public function MasterBarang()
    {
        return $this->HasMany(MasterBarang::class,'id_um','id');
    }
    public function Masterhistory()
    {
        return $this->HasMany(Masterhistory::class,'id_um','id');
    }
}
