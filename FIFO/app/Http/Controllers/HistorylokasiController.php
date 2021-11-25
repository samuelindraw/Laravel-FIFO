<?php

namespace App\Http\Controllers;

use App\historylokasi;
use Illuminate\Http\Request;

class HistorylokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $historylokasi =  historylokasi::All()->sortBy("tanggal");
        return view('/historylokasi/index', 
        [
            'title' => 'Lokasi History',
            "active" =>'historylokasi',
            'historylokasi'=> $historylokasi
        ]);
    }
    public function restore(Request $request)
    {
        $cekdate = historylokasi::orderBy('tanggal','ASC')->first();
        $createdAt = Carbon::parse($cekdate->tanggal);
        $date1 = $createdAt->format('Y-m-d');
        $date2 = $request->tanggal;
        $date = Carbon::createFromFormat('d-m-Y', $date2)->format('Y-m-d H:i:s');
        $historylokasi = historylokasi::where('tanggal', '<', $date)->get();
        //dd($history);
        if(!$historylokasi)
        {
            return redirect('/historylokasi/restore')->with('error','ERROR, tidak ada data, gagal restore !');
        }
        foreach($historylokasi as $history)
        {
            if($history->status = "INSERT")
            {
                $id = $history->id_lokasi;
                //cek data id dan kodebarang dan namabarang
                $kodeLokasi = $history->kodeLokasi;
                $namaLokasi = $history->namaLokasi;
                $cekdata = MasterLokasi::where('id', $id)->where('kodeLokasi', $kodeLokasi)->where('namaLokasi', $namaLokasi)->first();
                
                if(!$cekdata)
                {
                    
                    DB::connection('mysql')->beginTransaction();
                    $insert = new MasterBarang([
                        'id' => $id,
                        'kodeLokasi' => $history->kodeLokasi,
                        'namaLokasi' => $history->namaLokasi,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                    $insert->save();
                    DB::connection('mysql')->commit();
                }
            }
            if($history->status = "UPDATE")
            {
                $id = $history->id_lokasi;
                //cek data id dan kodebarang dan namabarang
                $kodeLokasi = $history->kodeLokasi;
                $namaLokasi = $history->namaLokasi;
                $cekdata = MasterLokasi::where('id', $id)->where('kodeLokasi', $kodeLokasi)->where('namaLokasi', $namaLokasi)->first();
                if($cekdata)
                {
                    DB::connection('mysql')->beginTransaction();
                    $update = MasterLokasi::where('namaLokasi', $namaLokasi)->first();
                    $update->namaLokasi = $namaLokasi;
                    $update->kodeLokasi = $kodeLokasi;
                    $update->save();
                    DB::connection('mysql')->commit();
                }
            }
        }
        return redirect('/MasterLokasi/index')->with('success','oke, data berhasil restore !');

    }
}
