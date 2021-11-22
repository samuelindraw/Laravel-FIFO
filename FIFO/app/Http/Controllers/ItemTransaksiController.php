<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Masterstok;
use App\MasterBarang;
use App\MasterLokasi;
use App\itemTransaksi;
use App\Masterhistory;
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
        $itemTransaksi = itemTransaksi::orderBy('bukti', 'desc')->get();
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
        //GET DATA BARANG 
        $barang = MasterBarang::all('id', 'kodeBarang');
        $lokasi = MasterLokasi::all('id', 'kodeLokasi');
        return view('/itemTransaksi/addTransaksi', 
        [
            'title' => "Transaksi",
            "active" =>'transaksi',
            'barang'=> $barang,
            'lokasi' => $lokasi
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

        //dd($request);
        //CEK TRANSAKSI TERAKIR YANG ADA TAMBAHNYA WHERE BUKTI LIKE TAMBAH AND SORT BY DATE DESC
        //AMBIL VALUE PERTAMA
        //LALU JALANKAN TAMBAH 0 DAN VALUE
        //REQUEST->BUKTI = BARU
        // $valid = itemTransaksi::where('kodeBarang', $request->kodeBarang)->where('loc_site', $request->loc_site)
        // ->latest()->first();
        $Masterstok = Masterstok::where('id_kodebarang', $request->id_kodebarang)->
        where('id_lokasi', $request->id_lokasi)->latest()->first();
        //dd($Masterstok);
        if($Masterstok != null)
        {
            // VALIDASI BUY KECUALI LOKSI NYA BEDA ? DAN BARANG BEDA ?
            if(strtotime(Carbon::createFromFormat('Y-m-d', $request->tgl_masuk)->format('Y-m-d H:i:s')) <= strtotime($Masterstok->tgl_masuk))
            {
                //dd('error disini');
                return redirect('/itemTransaksi/index')->with('error','ERROR, Tanggal masuk Pembelian/Penjualan !');
            }
            else
            {
                $validatedData = $request->validate([
                    'bukti' => 'required',
                    'id_lokasi' => 'required',
                    'id_kodebarang' => 'required',
                    'namaBarang' => 'required',
                    'um' => 'required',
                    'qty' => 'required',
                    'tgl_masuk' => 'required'
                ]);
                // KLO GA VALID ERROR DATA TIDAK VALID ? 
            }
        }
        // dd($request->loc_site);
        //dd($request->tgl_masuk, $valid->tgl_masuk);
       
        DB::connection('mysql')->beginTransaction();
        $buktibaru = '';
        if($request->bukti == "TAMBAH")
        {
            $tambah = itemTransaksi::where('bukti', 'LIKE', 'TAMBAH%')->latest()->first();
            // dd($tambah);
            if(!$tambah)
            {
                $buktibaru = 'TAMBAH01';
            }
            else
            {
                list($mem_prefix,$mem_num) = sscanf($tambah->bukti,"%[A-Za-z]%[0-9]");
                $buktibaru =  $mem_prefix . str_pad($mem_num + 1,2,'0',STR_PAD_LEFT);
            }
            //dd($buktibaru);  
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
            $cekhistory = Masterhistory::where('bukti', $buktibaru)->latest()->first();
            if(!$cekhistory)
            {
                //create history
                $masterhistory = new Masterhistory([
                    'bukti' => $buktibaru,
                    'tgl_trans' => Carbon::now()->format('Y-m-d'),
                    'jam' => Carbon::now()->format('H:i'),
                    'id_lokasi' => $request->id_lokasi,
                    'id_kodebarang' => $request->id_kodebarang,
                    'qty' => $request->qty,
                    'tgl_masuk' => Carbon::createFromFormat('Y-m-d', $request->tgl_masuk)->format('Y-m-d H:i:s'),
                    'program' => "RECEIPT",
                    'userid' => auth()->user()->username
                ]);
                //dd($masterhistory);
                $masterhistory->save();
            }

        }
        //BIKIN DROPDOWN MENU DAPET ID BLA BLA
        // BARANG_KELUAR AKU KE MASTER_STOK FOREACH 1-1 
        //
       DB::connection('mysql')->commit();
       return redirect('/itemTransaksi/index')->with('success','Data Berhasil ditambah');
    }
    public function kurang()
    {
        //GET DATA BARANG 
        $barang = MasterBarang::all('id', 'kodeBarang');
        $lokasi = MasterLokasi::all('id', 'kodeLokasi');
        return view('/itemTransaksi/kurangTransaksi', 
        [
            'title' => "Transaksi",
            "active" =>'transaksi',
            'barang'=> $barang,
            'lokasi' => $lokasi
        ]);
    }
    public function kurang_proses(Request $request)
    {

        //dd($request);
        //CEK TRANSAKSI TERAKIR YANG ADA TAMBAHNYA WHERE BUKTI LIKE TAMBAH AND SORT BY DATE DESC
        //AMBIL VALUE PERTAMA
        //LALU JALANKAN TAMBAH 0 DAN VALUE
        //REQUEST->BUKTI = BARU
        // $valid = itemTransaksi::where('kodeBarang', $request->kodeBarang)->where('loc_site', $request->loc_site)
        // ->latest()->first();
        $Masterstok = Masterstok::where('id_kodebarang', $request->id_kodebarang)->
        where('id_lokasi', $request->id_lokasi)->latest()->first();
        //dd($Masterstok);
        if($Masterstok != null)
        {
            // VALIDASI BUY KECUALI LOKSI NYA BEDA ? DAN BARANG BEDA ? udh ok
            if(strtotime(Carbon::createFromFormat('Y-m-d', $request->tgl_masuk)->format('Y-m-d H:i:s')) <= strtotime($Masterstok->tgl_masuk))
            {
                //dd('error disini');
                return redirect('/itemTransaksi/index')->with('error','ERROR, Tanggal masuk Pembelian/Penjualan !');
            }
            else
            {
                $validatedData = $request->validate([
                    'bukti' => 'required',
                    'id_lokasi' => 'required',
                    'id_kodebarang' => 'required',
                    'namaBarang' => 'required',
                    'um' => 'required',
                    'qty' => 'required',
                    'tgl_masuk' => 'required'
                ]);
                // KLO GA VALID ERROR DATA TIDAK VALID ? 
            }
            // }
            $kurang = itemTransaksi::where('bukti', 'LIKE', 'KURANG%')->latest()->first();
            if(!$kurang)
            {
                $buktikurang = 'KURANG01';
            }
            else
            {
                list($mem_prefix,$mem_num) = sscanf($kurang->bukti,"%[A-Za-z]%[0-9]");
                $buktikurang =  $mem_prefix . str_pad($mem_num + 1,2,'0',STR_PAD_LEFT);
            }
            DB::connection('mysql')->beginTransaction();
            $insert = new itemTransaksi([
                'bukti' => $buktikurang,
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
            // DB::connection('mysql')->commit();
            //dd($buktikurang);
            $itemstok = Masterstok::where('tgl_masuk', '<=' , Carbon::createFromFormat('Y-m-d', $request->tgl_masuk)->format('Y-m-d H:i:s'))
            ->where('id_kodebarang', $request->id_kodebarang)->where('qty' ,'>=', 0 )->orderBy('tgl_masuk', 'ASC')->get();
            $totalstok = Masterstok::where('tgl_masuk', '<=' , Carbon::createFromFormat('Y-m-d', $request->tgl_masuk)->format('Y-m-d H:i:s'))
            ->where('id_kodebarang', $request->id_kodebarang)->sum('qty');
            //dd($totalstok);
            //dapet data all itemstok 
            //dd($itemstok); => udah dapet 4 item data
            $temp = 0;
            //$qty = 0;
           
            if($totalstok < $request->qty) {
                return redirect('/itemTransaksi/index')->with('error','ERROR, Stok untuk penjualan tidak cukup !');
            }
            else {
                $qty = $request->qty;
                $tampungs = 0;
                $temp = $qty;
                foreach ($itemstok as $item) {
                    if ($qty > 0) {
                        $qty = $qty - $item->qty;
                        
                        $itemQty = $item->qty;
                        if ($qty > 0) {     
                            $stok_update = 0;
                            $tampungs = $qty;
                            // $tampungan = $request->qty - $qty; // 100 - 90 = 10
                            //brati tampungan saya update 
                            
                            // $update = Masterstok::where('id',$item->id)->first();
                            //dd($update,'if');
                            $item->qty = $stok_update;
                            $item->save();
                            $masterhistory = new Masterhistory([
                                'bukti' => $buktikurang,
                                'tgl_trans' => Carbon::createFromFormat('Y-m-d', $request->tgl_masuk)->format('Y-m-d H:i:s'),
                                'jam' => Carbon::now()->format('H:i'),
                                'id_lokasi' => $request->id_lokasi,  
                                'id_kodebarang' => $request->id_kodebarang,
                                'qty' =>  $item->qty > 0 ? $item->qty : '-'.$itemQty ,
                                'tgl_masuk' => $item->tgl_masuk,
                                'program' => "ISSUE",
                                'userid' => auth()->user()->username
                            ]);
                            //update history
                        } else {
                            $item->qty = abs($qty);
                            $item->save();
                            $masterhistory = new Masterhistory([
                                'bukti' => $buktikurang,
                                'tgl_trans' => Carbon::createFromFormat('Y-m-d', $request->tgl_masuk)->format('Y-m-d H:i:s'),
                                'jam' => Carbon::now()->format('H:i'),
                                'id_lokasi' => $request->id_lokasi,  
                                'id_kodebarang' => $request->id_kodebarang,
                                'qty' =>  $item->qty > 0 ? '-'.$tampungs : '-'.$itemQty ,
                                'tgl_masuk' => $item->tgl_masuk,
                                'program' => "ISSUE",
                                'userid' => auth()->user()->username
                            ]);
                        }                 
                        //DB::connection('mysql')->commit();
                        // $cekhistory = Masterhistory::where('bukti', $buktikurang)->latest()->first();
                        //cek LIST
                        // if(!$cekhistory) {
                            //nama e generate sendiri susah
                            // $kurang = itemTransaksi::where('bukti', 'LIKE', 'KURANG%')->latest()->first();

                            // list($mem_prefix,$mem_num) = sscanf($kurang->bukti,"%[A-Za-z]%[0-9]");
                            // $mem_num = $mem_num;
                            // $buktihistory =  $mem_prefix . str_pad($mem_num + 1,2,'0',STR_PAD_LEFT);
                            //create history
                        // dd($item->qty);
                        
                        //dd($masterhistory);
                        $masterhistory->save();
                            // DB::connection('mysql')->commit();
                        // }
                        // else
                        // {
                        //     //dd("ABC");
                        // }
                    }
                    
                    else{
                           
                        $stok_update = $item->qty - $qty;
                        //dd($stok_update);
                        // dd($qty);
                        //dd($stok_update);
                        // $update = Masterstok::where('id',$item->id)->first();
                        //dd($update);
                        $item->qty = $stok_update;
                        $item->save();
                        // DB::connection('mysql')->commit();
                        $kurang = itemTransaksi::where('bukti', 'LIKE', 'KURANG%')->latest()->first();
                        $cekhistory = Masterhistory::where('bukti', $buktikurang)->latest()->first();
                        //cek LISTmm m
                        list($mem_prefix,$mem_num) = sscanf($kurang->bukti,"%[A-Za-z]%[0-9]");
                        $buktihistory =  $mem_prefix . str_pad($mem_num + 1,2,'0',STR_PAD_LEFT);
                        // if($cekhistory)
                        // {
                            //create history
                            $masterhistory = new Masterhistory([
                                'bukti' => $buktikurang,
                                'tgl_trans' => Carbon::createFromFormat('Y-m-d', $request->tgl_masuk)->format('Y-m-d H:i:s'),
                                'jam' => Carbon::now()->format('H:i'),
                                'id_lokasi' => $request->id_lokasi,
                                'id_kodebarang' => $request->id_kodebarang,
                                'qty' =>  $item->qty - $request->qty,
                                'tgl_masuk' => $item->tgl_masuk,
                                'program' => "ISSUE",
                                'userid' => auth()->user()->username
                            ]);
                            //dd($masterhistory);
                            $masterhistory->save();
                            // DB::connection('mysql')->commit();
                        // }
                    }
                }
            }
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
