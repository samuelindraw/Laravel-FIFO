<?php

namespace App\Http\Controllers;

use App\Masterum;
use Carbon\Carbon;
use App\MasterBarang;
use App\historybarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'title' => 'Master Barang',
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
        $masterum = Masterum::all();
        return view('/MasterBarang/addBarang', 
        [
            'title' => "Master Barang",
            "active" =>'masterbarang',
            'masterum'=> $masterum,
        ]);
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
            'kodeBarang' => 'required|unique:master_barangs',
            'namaBarang' => 'required|min:3|unique:master_barangs',
            'id_um' =>'required'
        ]);
       $masterbrg = MasterBarang::where('namaBarang', $request->namaBarang)->where('kodeBarang', $request->kodeBarang)->first();
       if(!$masterbrg)
       {
           try{
                MasterBarang::create($validatedData);
                $cekbarang = MasterBarang::where('namaBarang', $request->namaBarang)->first();
                DB::connection('mysql')->beginTransaction();
                $insert = new historybarang([
                    'id_barang' => $cekbarang->id,
                    'kodeBarang' => $request->kodeBarang,
                    'namaBarang' => $request->namaBarang,
                    'id_um' => $request->id_um,
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
                {DB::rollBack();
                return redirect('/MasterBarang/index')->with('error', $e->getMessage());
                //throw $e;
                
            } 
        } 
            
       }
       else
       {
            return redirect('/MasterBarang/index')->with('error','Data tidak boleh sama');
       }
      
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
            'title' => 'Master Barang',
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
        $masterum = Masterum::all();
        return view('/MasterBarang/editBarang', 
        [
            'title' => "Data edit : $editdata->kodeBarang",
            "active" =>'editdata',
            'masterBarang'=> $editdata,
            'masterum' => $masterum
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
        'namaBarang' => 'required'
        ]);
        dd($validatedData);
        MasterBarang::where('id',$request->id)->update([
            'kodeBarang' => $request->kodeBarang,
            'namaBarang' => $request->namaBarang,
            'id_um' => $request->id_um
        ]);
        try{
            DB::connection('mysql')->beginTransaction();
            $insert = new historybarang([
                'id_barang' => $request->id,
                'kodeBarang' => $request->kodeBarang,
                'namaBarang' => $request->namaBarang,
                'id_um' => $request->id_um,
                'tanggal' => Carbon::now(),
                'status' => "UPDATE",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            $insert->save();
        }
        catch (\Exception $e) {
            //dd('KAWKOKOAKOWKOEA');
            //dd($e->message);
            //report($e->getMessage());
            {DB::rollBack();
            return redirect('/MasterBarang/index')->with('error', $e->getMessage());
            throw $e;
            
        }  
    }
       
        DB::connection('mysql')->commit();
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
