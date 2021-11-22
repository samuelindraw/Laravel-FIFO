<?php

namespace App\Exports;

use App\Masterhistory;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class masterhistoryExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Masterhistory::all();
    }
    public function headings(): array
    {
        return [
            'BUKTI',
            'TGL TRANS',
            'JAM',
            'KODE LOKASI',
            'NAMA LOKASI',
            'KODE BARANG',
            'NAMA BARANG',
            'TGL MASUK',
            'QTY',
            'PROGRAM',
            'USERID'
        ];
    }
}
