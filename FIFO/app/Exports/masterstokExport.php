<?php

namespace App\Exports;

use App\Masterstok;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class masterstokExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Masterstok::all()->except('id', 'created_at' , 'updated_at');
    }
    // public function headings(): array
    // {
    //     return [
    //         'kode Lokasi',
    //         'Nama Lokasi',
    //         'Kode Barang',
    //         'Nama Barang',
    //         'Tgl Masuk',
    //         'qTy',
    //         'um'
    //     ];
    // }
}
