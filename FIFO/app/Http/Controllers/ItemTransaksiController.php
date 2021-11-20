<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Masterstok;
use App\MasterBarang;
use App\itemTransaksi;
use Illuminate\Http\Request;

class ItemTransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $itemTransaksi = itemTransaksi::orderBy('tgl_masuk', 'desc')->get();
        // foreach($itemTransaksi as $item)
        // {
        //     dd(optional($item->MasterLokasi)->namaLokasi);
        // }
        return view('/itemTransaksi/index', 
        [
            'title' => 'Transaksi',
            "active" =>'Transaksi',
            'itemTransaksi'=> $itemTransaksi
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('/itemTransaksi/addTransaksi');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //CEK TRANSAKSI TERAKIR YANG ADA TAMBAHNYA WHERE BUKTI LIKE TAMBAH AND SORT BY DATE DESC
        //AMBIL VALUE PERTAMA
        //LALU JALANKAN TAMBAH 0 DAN VALUE
        //REQUEST->BUKTI = BARU
        // $valid = itemTransaksi::where('kodeBarang', $request->kodeBarang)->where('loc_site', $request->loc_site)
        // ->latest()->first();
        $Masterstok = Masterstok::where('id_kodebarang', $request->id_kodebarang)->
        where('id_lokasi', $request->id_lokasi)->latest()->first();
        // dd($request->loc_site);
        //dd($request->tgl_masuk, $valid->tgl_masuk);
        if(strtotime(Carbon::createFromFormat('Y-m-d', $request->tgl_masuk)->format('Y-m-d H:i:s')) <= strtotime($Masterstok->tgl_masuk))
        {
            
        }
        else
        {
            $validatedData = $request->validate([
                'bukti' => 'required',
                'loc_site' => 'required',
                'kodeBarang' => 'required',
                'namaBarang' => 'required',
                'um' => 'required',
                'qty' => 'required',
                'tgl_masuk' => 'required'
            ]);
            // itemTransaksi::create($validatedData);
        }
        DB::connection('mysql')->beginTransaction();
        $buktibaru = '';
        if($request->bukti == "TAMBAH")
        {
            $tambah = itemTransaksi::where('bukti', 'LIKE', 'TAMBAH%')->latest()->first();
            list($mem_prefix,$mem_num) = sscanf($tambah->bukti,"%[A-Za-z]%[0-9]");
            $buktibaru =  $mem_prefix . str_pad($mem_num + 1,2,'0',STR_PAD_LEFT);
            // dd($buktibaru);  
            // $request->bukti = $buktibaru; 
            $insert = new itemTransaksi([
                'bukti' => $buktibaru,
                'id_lokasi' => $request->id_lokasi,
                'id_kodebarang' => $request->id_kodebarang,
                'namaBarang'=> $request->namaBarang,
                'um' => $request->um,
                'qty' => $request->qty,
                'tgl_masuk' => Carbon::createFromFormat('Y-m-d', $request->tgl_masuk)->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            $insert->save();
                //    $update = MasterBarang::where('kodeBarang',$request->kodeBarang)->first();
                //    $update->totalstok = $update->totalstok + $request->qty;
                //    $update->save();
            $cekmasterstok = Masterstok::where('id_lokasi', $request->id_lokasi)->where('id_kodebarang', $request->id_kodebarang)
            ->where('tgl_masuk', $request->tgl_masuk)->latest()->first();
            if(!$cekmasterstok)
            {
                $createstok = new Masterstok([
                    'id_lokasi' => $request->id_lokasi,
                    'id_kodebarang' => $request->id_kodebarang,
                    'qty' => $request->qty,
                    'tgl_masuk' => $insert->tgl_masuk,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                $createstok->save();
            }

        }
        //BIKIN DROPDOWN MENU DAPET ID BLA BLA
        // BARANG_KELUAR AKU KE MASTER_STOK FOREACH 1-1 
        // 
        
        if($request->bukti == "KURANG")
        {
            $kurang = itemTransaksi::where('bukti', 'LIKE', 'KURANG%')->latest()->first();
            list($mem_prefix,$mem_num) = sscanf($kurang->bukti,"%[A-Za-z]%[0-9]");
            $buktibaru =  $mem_prefix . str_pad($mem_num + 1,2,'0',STR_PAD_LEFT);
            if($kurang->bukti == "")
            {
                $buktikurang = 'KURANG01';
            }
            $itemstok = itemTransaksi::where('tgl_masuk', '<=' , Carbon::createFromFormat('Y-m-d', $request->tgl_masuk)->format('Y-m-d H:i:s'))
            ->where('kodeBarang', $request->kodeBarang)->orderBy('tgl_masuk', 'asc')->get();
            $tampungan = 0;
            foreach($itemstok as $item)
            {
                if($tampungan == 0)
                {
                    $tampungan = $request->qty;
                    //update
                }
                
            }
            $sisa = 0;
        }
       DB::connection('mysql')->commit();
       return redirect('/itemTransaksi/index')->with('success','Data Berhasil ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\itemTransaksi  $itemTransaksi
     * @return \Illuminate\Http\Response
     */
    public function show(itemTransaksi $itemTransaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\itemTransaksi  $itemTransaksi
     * @return \Illuminate\Http\Response
     */
    public function edit(itemTransaksi $itemTransaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\itemTransaksi  $itemTransaksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, itemTransaksi $itemTransaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\itemTransaksi  $itemTransaksi
     * @return \Illuminate\Http\Response
     */
    public function destroy(itemTransaksi $itemTransaksi)
    {
        //
    }
}
