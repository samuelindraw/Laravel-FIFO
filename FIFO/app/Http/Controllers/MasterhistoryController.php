<?php

namespace App\Http\Controllers;

use App\MasterBarang;
use App\MasterLokasi;
use App\Masterhistory;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Exports\masterhistoryExport;
use Maatwebsite\Excel\Facades\Excel;

class MasterhistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $masterhistory =  Masterhistory::orderBy('id', 'ASC')->get();
        return view('Masterhistory/index', 
        [
            'title' => 'Master History',
            "active" =>'history',
            'masterhistory'=> $masterhistory
        ]);
    }
    public function export_excel()
	{
		return Excel::download(new masterhistoryExport, 'history.xlsx');
	}
    public function cetak_pdf()
    {
    	$masterhistory = Masterhistory::all();
 
    	$pdf = PDF::loadview('/Masterhistory/masterhistory',['masterhistory'=>$masterhistory])->setPaper('a4', 'landscape');
    	return $pdf->download('laporan-History-pdf');
    }
    public function show(Request $request)
    {
        if($request->bukti != "")
        {
            $masterhistory = Masterhistory::where('bukti','LIKE','%'.$request->bukti.'%')->get();
            $bukti = $request->bukti;
            return view('/Masterhistory/index', 
            [
                'title' => 'Master_Barang',
                "bukti" =>$bukti,
                'masterhistory'=> $masterhistory
            ]);
        }
        if($request->tgl_trans != "")
        {
            $masterhistory = Masterhistory::where('tgl_trans','LIKE','%'.$request->tgl_trans.'%')->get();
            $tgl_trans = $request->tgl_trans;
            return view('/Masterhistory/index', 
            [
                'title' => 'Master_Barang',
                "tgl_trans" =>$tgl_trans,
                'masterhistory'=> $masterhistory
            ]);
        }
        if($request->kodeLokasi != "")
        {
            $masterhistory = MasterLokasi::where('kodeLokasi', $request->kodeLokasi)->first();
            $masterhistory = Masterhistory::where('id_lokasi','LIKE','%'.$masterhistory->id.'%')->get();
            $kodeLokasi = $request->kodeLokasi;
            return view('/Masterhistory/index', 
            [
                'title' => 'Master_Barang',
                "kodeLokasi" =>$kodeLokasi,
                'masterhistory'=> $masterhistory
            ]);
        }
        if($request->kodeBarang != "")
        {
            $masterhistory = MasterBarang::where('kodeBarang', $request->kodeBarang)->first();
            $masterhistory = Masterhistory::where('id_kodebarang','LIKE','%'.$masterhistory->id.'%')->get();
            $kodeBarang = $request->kodeBarang;
            return view('/Masterhistory/index', 
            [
                'title' => 'Master_Barang',
                "kodeBarang" =>$kodeBarang,
                'masterhistory'=> $masterhistory
            ]);
        }
        $masterhistory = Masterhistory::all();
        return view('/Masterhistory/index', 
            [
                'title' => 'Master_Barang',
                'masterhistory'=> $masterhistory
            ]);

    }
}
