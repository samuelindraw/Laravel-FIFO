<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\MasterBarang;
use App\historybarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistorybarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $historybarang =  historybarang::All()->sortBy("tanggal");
        return view('/historybarang/index', 
        [
            'title' => 'Barang History',
            "active" =>'historybarang',
            'historybarang'=> $historybarang
        ]);
    }
    public function restore(Request $request)
    {
        $cekdate = historybarang::orderBy('tanggal','ASC')->first();
        $createdAt = Carbon::parse($cekdate->tanggal);
        $date1 = $createdAt->format('Y-m-d');
        $date2 = $request->tanggal;
        $date = Carbon::createFromFormat('d-m-Y', $date2)->format('Y-m-d H:i:s');
        $historybarang = historybarang::where('tanggal', '<', $date)->get();
        //dd($history);
        if(!$historybarang)
        {
            return redirect('/historybarang/restore')->with('error','ERROR, tidak ada data, gagal restore !');
        }
        foreach($historybarang as $history)
        {
            if($history->status = "INSERT")
            {
                $id = $history->id_barang;
                //cek data id dan kodebarang dan namabarang
                $kodeBarang = $history->kodeBarang;
                $namaBarang = $history->namaBarang;
                $id_um = $history->id_um;
                $cekdata = MasterBarang::where('id', $id)->where('kodeBarang', $kodeBarang)->where('namaBarang', $namaBarang)->first();
                
                if(!$cekdata)
                {
                    
                    DB::connection('mysql')->beginTransaction();
                    $insert = new MasterBarang([
                        'id' => $id,
                        'kodeBarang' => $history->kodeBarang,
                        'namaBarang' => $history->namaBarang,
                        'id_um' =>  $history->id_um,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                    $insert->save();
                    DB::connection('mysql')->commit();
                }
            }
            if($history->status = "UPDATE")
            {
                $id = $history->id_barang;
                //cek data id dan kodebarang dan namabarang
                $kodeBarang = $history->kodeBarang;
                $namaBarang = $history->namaBarang;
                $id_um = $history->id_um;
                $cekdata = MasterBarang::where('id', $id)->where('kodeBarang', $kodeBarang)->where('namaBarang', $namaBarang)->first();
                if($cekdata)
                {
                    DB::connection('mysql')->beginTransaction();
                    $update = MasterBarang::where('namaBarang', $namaBarang)->first();
                    $update->namaBarang = $namaBarang;
                    $update->id_um = $id_um;
                    $update->kodeBarang = $kodeBarang;
                    $update->save();
                    DB::connection('mysql')->commit();
                }
            }
        }
        return redirect('/MasterBarang/index')->with('success','oke, data berhasil restore !');

    }
}
