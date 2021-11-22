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
        $masterstok =  Masterstok::orderBy('id_kodebarang', 'asc')->get();
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
        $masterstok = Masterstok::where('id_kodebarang','LIKE','%'.$request->id_kodebarang.'%')->get();
        return view('/Masterstok/index', 
        [
            'title' => 'Master Stok',
            "kunci" =>$request->id_kodebarang,
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
