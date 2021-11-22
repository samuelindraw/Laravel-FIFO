<?php

namespace App\Http\Controllers;

use App\Masterhistory;
use Illuminate\Http\Request;
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
        $masterhistory =  Masterhistory::orderBy('id_kodebarang', 'asc')->get();
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
     * @param  \App\Masterhistory  $masterhistory
     * @return \Illuminate\Http\Response
     */
    public function show(Masterhistory $masterhistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Masterhistory  $masterhistory
     * @return \Illuminate\Http\Response
     */
    public function edit(Masterhistory $masterhistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Masterhistory  $masterhistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Masterhistory $masterhistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Masterhistory  $masterhistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Masterhistory $masterhistory)
    {
        //
    }
}
