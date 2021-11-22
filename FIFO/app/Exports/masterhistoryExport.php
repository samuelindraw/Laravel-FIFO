<?php

namespace App\Exports;

use App\Masterhistory;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class masterhistoryExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Masterhistory::all()->except('id', 'created_at' , 'updated_at');
    }
    // public function headings(): array
    // {
    //     return [
    //         'BUKTI',
    //         'TGL TRANS',
    //         'JAM',
    //         'KODE LOKASI',
    //         'KODE BARANG',
    //         'TGL MASUK',
    //         'QTY',
    //         'PROGRAM',
    //         'USERID'
    //     ];
    // }
}
