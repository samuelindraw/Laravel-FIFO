<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Masterstok;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class masterstokExport implements FromCollection,WithHeadings,WithMapping,ShouldAutoSize,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Masterstok::with('MasterBarang')->with('MasterLokasi')->orderBy('id_lokasi','asc')->get();
    }
    public function map($masterstok) : array {
        return [
            $masterstok->MasterLokasi->kodeLokasi,
            $masterstok->MasterLokasi->namaLokasi,
            $masterstok->MasterBarang->kodeBarang,
            $masterstok->MasterBarang->namaBarang,
            Carbon::parse($masterstok->tgl_masuk)->format('d/m/Y'),
            $masterstok->qty,
            $masterstok->Masterum->um
        ] ; 
    }
    public function headings(): array
    {
        return [
            'KODE LOKASI ',
            'NAMA LOKASI ',
            'KODE BARANG ',
            'NAMA BARANG ',
            'TGL MASUK ',
            'QTY ',
            'UM '
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
                $masterstok = Masterstok::all()->count();
                //dd($masterhistory);
                $test = $masterstok + 1;
                //dd($test);
                $cellRange = 'A1:G1'; // All headers
                //$event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setName('Calibri');
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
                $event->sheet->getStyle($cellRange)->ApplyFromArray($styleArray);
                $event->sheet->getStyle('A2:G'.$test)->ApplyFromArray($styleArray);
            },
        ];
    }
}
