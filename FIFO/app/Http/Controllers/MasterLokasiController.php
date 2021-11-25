<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\MasterLokasi;
use App\historybarang;
use App\historylokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'title' => 'Master Lokasi',
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
            'kodeLokasi' => 'required|unique:master_lokasis',
            'namaLokasi' => 'required|unique:master_lokasis'
        ]);
       $lokasi = MasterLokasi::where('namaLokasi', $request->namaLokasi)->where('kodeLokasi', $request->kodeLokasi)->first();
       if(!$lokasi)
       {
           try{
            MasterLokasi::create($validatedData);
            $ceklokasi = MasterLokasi::where('namaLokasi', $request->namaLokasi)->first();
            DB::connection('mysql')->beginTransaction();
            $insert = new historylokasi([
                'id_lokasi' => $ceklokasi->id,
                'kodeLokasi' => $request->kodeLokasi,
                'namaLokasi' => $request->namaLokasi,
                'tanggal' => Carbon::now(),
                'status' => "INSERT",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            $insert->save();
            DB::connection('mysql')->commit();
        }catch (\Exception $e) {
            //dd('KAWKOKOAKOWKOEA');
            //dd($e->message);
            //report($e->getMessage());
            DB::rollBack();
            return redirect('/MasterLokasi/index')->with('error', $e->getMessage());
            throw $e;
            
        }      
       }
       else
       {
        return redirect('/MasterLokasi/index')->with('error','Data tidak boleh sama');
       }
      
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
            'kodeLokasi' => 'required|unique:master_lokasis',
            'namaLokasi' => 'required|unique:master_lokasis'
        ]);
        MasterLokasi::where('id',$request->id)->update([
		'kodeLokasi' => $request->kodeLokasi,
		'namaLokasi' => $request->namaLokasi
	]);
    DB::connection('mysql')->beginTransaction();
    try{
        $insert = new historybarang([
            'id_lokasi' => $request->id,
            'kodeLokasi' => $request->kodeLokasi,
            'namaLokasi' => $request->namaLokasi,
            'tanggal' => Carbon::now(),
            'status' => "UPDATE",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        $insert->save();
        DB::connection('mysql')->commit();
    }catch (\Exception $e) {
        //dd('KAWKOKOAKOWKOEA');
        //dd($e->message);
        //report($e->getMessage());
        DB::rollBack();
        return redirect('/MasterLokasi/index')->with('error', $e->getMessage());
        throw $e;
        
    }      
   
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
