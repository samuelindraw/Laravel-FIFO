<?php

namespace App\Http\Controllers;

use App\Masterstok;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Exports\masterstokExport;
use Maatwebsite\Excel\Facades\Excel;


class MasterstokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $masterstok =  Masterstok::orderBy('id_lokasi', 'asc')->get();
        return view('Masterstok/index', 
        [
            'title' => 'Master stok',
            "active" =>'masterstok',
            'masterstok'=> $masterstok
        ]);
    }
    public function export_excel()
	{
		return Excel::download(new masterstokExport, 'masterstok.xlsx');
	}
    public function show(Request $request)
    {
        if($request->bukti != "")
        {
            $lokasi = MasterLokasi::where('kodeLokasi',$request->kodeLokasi)->first();
            $masterstok = Masterstok::where('id_lokasi','LIKE','%'.$lokasi->id.'%')->get();
            $kodeLokasi = $request->kodeLokasi;
            return view('/Masterstok/index', 
            [
                'title' => 'Master Stok',
                "kodeLokasi" =>$bukti,
                'masterstok'=> $masterstok
            ]);
        }
        if($request->kodeBarang !="")
        {
            $barang = MasterBarang::where('kodeBarang',$request->kodeBarang)->first();
            $masterstok = Masterstok::where('id_kodebarang','LIKE','%'.$barang->id.'%')->get();
            return view('/Masterstok/index', 
            [
                'title' => 'Master Stok',
                "kodeBarang" =>$request->kodeBarang,
                'masterstok'=> $masterstok
            ]);
        }
            $masterstok = Masterstok::all();
            return view('/Masterstok/index', 
            [
                'title' => 'Master Stok',
                'masterstok'=> $masterstok
            ]);
    
    }
    public function cetak_pdf()
    {
    	$masterstok = Masterstok::all();
 
    	$pdf = PDF::loadview('/Masterstok/Masterstok_pdf',['masterstok'=>$masterstok]);
    	return $pdf->download('laporan-stok-pdf');
    }
}
