<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Masterhistory;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class masterhistoryExport implements FromCollection,WithHeadings,WithMapping,ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Masterhistory::with('MasterBarang')->with('MasterLokasi')->orderBy('tgl_trans','asc')->get();
        // return Masterhistory::with('MasterBarang:id,username')->get();
    }
    public function map($masterhistory) : array {
        return [
            $masterhistory->bukti,
            Carbon::parse($masterhistory->tgl_trans)->format('d/m/Y'),
            Carbon::createFromFormat('Y-m-d', $masterhistory->tgl_trans)->format('H:i'),
            $masterhistory->MasterLokasi->kodeLokasi,
            $masterhistory->MasterLokasi->namaLokasi,
            $masterhistory->MasterBarang->kodeBarang,
            $masterhistory->MasterBarang->namaBarang,
            Carbon::parse($masterhistory->tgl_masuk)->format('d/m/Y'),
            $masterhistory->qty,
            $masterhistory->program,
            $masterhistory->userid
        ] ; 
    }
    public function headings(): array
    {
        return [
            'BUKTI ',
            'TGL TRANS ',
            'JAM ',
            'KODE LOKASI ',
            'NAMA LOKASI ',
            'KODE BARANG ',
            'NAMA BARANG ',
            'TGL MASUK ',
            'QTY ',
            'PROGRAM ',
            'USERID '
        ];
    }
    public function registerEvents(): array
    {  
        //border style
		$styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                //'color' => ['argb' => 'FFFF0000'],
                    ],
                ],
            ];
        return [
            AfterSheet::class    => function(AfterSheet $event) use ($styleArray)
            {
                $masterhistory = Masterhistory::all()->count();
                //dd($masterhistory);
                $test = $masterhistory + 1;
                //dd($test);
                $cellRange = 'A1:K1'; // All headers
                //$event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setName('Calibri');
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
                $event->sheet->getStyle($cellRange)->ApplyFromArray($styleArray);
                $event->sheet->getStyle('A2:K'.$test)->ApplyFromArray($styleArray);
            },
        ];
    }
}
