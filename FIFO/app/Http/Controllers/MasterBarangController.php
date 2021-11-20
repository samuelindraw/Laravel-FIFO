<?php

namespace App\Http\Controllers;

use App\MasterBarang;
use Illuminate\Http\Request;

class MasterBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $masterBarang =  MasterBarang::All()->sortBy("date");
        return view('/MasterBarang/index', 
        [
            'title' => 'masterbarang',
            "active" =>'masterbarang',
            'masterBarang'=> $masterBarang
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('/MasterBarang/addBarang');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kodeBarang' => 'required',
            'namaBarang' => 'required',
            'um' => 'required'
        ]);
       MasterBarang::create($validatedData);
       return redirect('/MasterBarang/index')->with('success','Data Berhasil ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MasterBarang  $masterBarang
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $masterBarang = MasterBarang::where('kodeBarang','LIKE','%'.$request->kodeBarang.'%')->get();
        return view('/MasterBarang/index', 
        [
            'title' => 'Master_Barang',
            "kunci" =>$request->kodeBarang,
            'masterBarang'=> $masterBarang
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MasterBarang  $masterBarang
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editdata =  MasterBarang::All()->firstWhere('id', $id);
        return view('/MasterBarang/editBarang', 
        [
            'title' => "Data edit : $editdata->kodeBarang",
            "active" =>'editdata',
            'masterBarang'=> $editdata
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MasterBarang  $masterBarang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
        'kodeBarang' => 'required',
        'namaBarang' => 'required',
        'um' => 'required'
        ]);
        MasterBarang::where('id',$request->id)->update([
        'kodeBarang' => $request->kodeBarang,
        'namaBarang' => $request->namaBarang,
        'um' => $request->um
        ]);
        //$request->session()->flash('success','Registration Success');
        return redirect('/MasterBarang/index')->with('success','Data Berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MasterBarang  $masterBarang
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $masterBarang = MasterBarang::destroy($id);
        return redirect('/MasterBarang/index')->with('delete','Data Berhasil didelete');
    }
}
