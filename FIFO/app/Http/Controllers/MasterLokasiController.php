<?php

namespace App\Http\Controllers;

use App\MasterLokasi;
use Illuminate\Http\Request;

class MasterLokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $masterLokasi =  MasterLokasi::All();
        return view('MasterLokasi/index', 
        [
            'title' => 'Master_Lokasi',
            "active" =>'masterlokasi',
            'masterLokasi'=> $masterLokasi
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('MasterLokasi/addLokasi');
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
            'kodeLokasi' => 'required',
            'namaLokasi' => 'required'
        ]);
       MasterLokasi::create($validatedData);
       //$request->session()->flash('success','Registration Success');
       return redirect('MasterLokasi/index')->with('success','Data Berhasil ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MasterLokasi  $masterLokasi
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $masterLokasi = MasterLokasi::where('kodeLokasi','LIKE','%'.$request->kodeLokasi.'%')->get();
        return view('/MasterLokasi/index', 
        [
            'title' => 'Master Lokasi',
            "kunci" =>$request->kodeLokasi,
            'masterLokasi'=> $masterLokasi
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MasterLokasi  $masterLokasi
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editdata =  MasterLokasi::All()->firstWhere('id', $id);
        return view('MasterLokasi/editLokasi', 
        [
            'title' => "Data edit : $editdata->kodeLokasi",
            "active" =>'editdata',
            'masterLokasi'=> $editdata
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MasterLokasi  $masterLokasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'kodeLokasi' => 'required',
            'namaLokasi' => 'required'
        ]);
        MasterLokasi::where('id',$request->id)->update([
		'kodeLokasi' => $request->kodeLokasi,
		'namaLokasi' => $request->namaLokasi
	]);
       //$request->session()->flash('success','Registration Success');
       return redirect('MasterLokasi/index')->with('success','Data Berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MasterLokasi  $masterLokasi
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $masterlokasi= MasterLokasi::destroy($id);
        return redirect('MasterLokasi/index')->with('delete','Data Berhasil didelete');
    }
}
