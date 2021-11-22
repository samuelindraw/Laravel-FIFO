<?php

namespace App\Http\Controllers;

use App\Masterstok;
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
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Masterstok  $masterstok
     * @return \Illuminate\Http\Response
     */
    public function show(Masterstok $masterstok)
    {
        $masterstok = Masterstok::where('id_kodebarang','LIKE','%'.$request->id_kodebarang.'%')->get();
        return view('/Masterstok/index', 
        [
            'title' => 'Master Stok',
            "kunci" =>$request->id_kodebarang,
            'masterLokasi'=> $masterstok
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Masterstok  $masterstok
     * @return \Illuminate\Http\Response
     */
    public function edit(Masterstok $masterstok)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Masterstok  $masterstok
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Masterstok $masterstok)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Masterstok  $masterstok
     * @return \Illuminate\Http\Response
     */
    public function destroy(Masterstok $masterstok)
    {
        //
    }
}
