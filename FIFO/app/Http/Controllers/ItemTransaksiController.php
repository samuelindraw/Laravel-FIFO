<?php

namespace App\Http\Controllers;

use DB;
use App\Masterum;
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
        $itemTransaksi = itemTransaksi::orderBy('bukti', 'asc')->get();
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
        $validatedData = $request->validate([
            'bukti' => 'required',
            'id_lokasi' => 'required',
            'namaLokasi' => 'required',
            'id_kodebarang' => 'required',
            'namaBarang' => 'required',
            'um' => 'required',
            'qty' => 'required|integer|min:0',
        ]);
        $um = Masterum::where('um', $request->um)->first();
        $ceklokasi = MasterLokasi::where('id', $request->id_lokasi)->first();
        $barang = MasterBarang::all('id', 'kodeBarang');
        $lokasi = MasterLokasi::all('id', 'kodeLokasi');
        //dd($request->tgl_masuk);
        if(!$ceklokasi)
        {
            return redirect()->back()->withInput([
                   
                'id_lokasi' => $request->id_lokasi,
                'id_kodebarang' => $request->id_kodebarang,
                'namaBarang'=> $request->namaBarang,
                'id_um' => $um->id,
                'qty' => $request->qty,
                'tgl_masuk' => Carbon::createFromFormat('d/m/Y', $request->tgl_masuk)->format('Y-m-d H:i:s'),
                'barang'=> $barang,
                'lokasi' => $lokasi

            ])->with( 'error', 'ERROR, Lokasi tidak ditemukan !');
        }
        $cekbarang = MasterBarang::where('id', $request->id_kodebarang)->first();
        if(!$cekbarang)
        {
            //sdd('test');
            return redirect()->back()->withInput([
                   
                'id_lokasi' => $request->id_lokasi,
                'id_kodebarang' => $request->id_kodebarang,
                'namaBarang'=> $request->namaBarang,
                'id_um' => $um->id,
                'qty' => $request->qty,
                'tgl_masuk' => Carbon::createFromFormat('d/m/Y', $request->tgl_masuk)->format('Y-m-d H:i:s'),
                'barang'=> $barang,
                'lokasi' => $lokasi

            ])->with( 'error', 'ERROR, kode barant tidak ada !');
        }
        $Masterstok = Masterstok::where('id_kodebarang', $request->id_kodebarang)->
        where('id_lokasi', $request->id_lokasi)->latest()->first();
        //dd($Masterstok);
        if($Masterstok != null)
        {
           
            // VALIDASI BUY KECUALI LOKSI NYA BEDA ? DAN BARANG BEDA ?
            if(strtotime(Carbon::createFromFormat('d/m/Y', $request->tgl_masuk)->format('Y-m-d H:i:s')) <= strtotime($Masterstok->tgl_masuk))
            {
               
                //balikin datanya dihalaman sebelum ini
                 return redirect()->back()->withInput([
                   
                    'id_lokasi' => $request->id_lokasi,
                    'id_kodebarang' => $request->id_kodebarang,
                    'namaBarang'=> $request->namaBarang,
                    'id_um' => $um->id,
                    'qty' => $request->qty,
                    'tgl_masuk' => Carbon::createFromFormat('d/m/Y', $request->tgl_masuk)->format('Y-m-d H:i:s'),
                    'barang'=> $barang,
                    'lokasi' => $lokasi

                ])->with( 'error', 'ERROR, Tanggal masuk Pembelian/Penjualan !');
               
            }
            else
            {
                
                //dd($validatedData);
                // KLO GA VALID ERROR DATA TIDAK VALID ? 
            }
        }
        DB::connection('mysql')->beginTransaction();
        try{
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
                
                // $request->bukti = $buktibaru; 
                $insert = new itemTransaksi([
                    'bukti' => $buktibaru,
                    'id_lokasi' => $request->id_lokasi,
                    'id_kodebarang' => $request->id_kodebarang,
                    'namaBarang'=> $request->namaBarang,
                    'id_um' => $um->id,
                    'qty' => $request->qty,
                    'tgl_masuk' => Carbon::createFromFormat('d/m/Y', $request->tgl_masuk)->format('Y-m-d H:i:s'),
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
                        'id_um' => $um->id,
                        'tgl_masuk' => Carbon::createFromFormat('d/m/Y', $request->tgl_masuk)->format('Y-m-d H:i:s'),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                    $createstok->save();
                }
                else
                {
                    //dd("MASHOOOKKK");
                    //jalanin fungsi UPDATE klo misal ternyata datanya ada maka akan di cari dan ditambah 
                    $update = Masterstok::where('id',$cekmasterstok->id)->lockForUpdate()->first();
                    $update->qty = $update->qty + $request->qty;
                    $update->save();
                }
                $cekhistory = Masterhistory::where('bukti', $buktibaru)->latest()->first();
                if(!$cekhistory)
                {
                    //create history
                    $masterhistory = new Masterhistory([
                        'bukti' => $buktibaru,
                        'tgl_trans' => Carbon::now()->format('Y-m-d'),
                        'id_lokasi' => $request->id_lokasi,
                        'id_kodebarang' => $request->id_kodebarang,
                        'id_um' => $um->id,
                        'qty' => $request->qty,
                        'tgl_masuk' => Carbon::createFromFormat('d/m/Y', $request->tgl_masuk)->format('Y-m-d H:i:s'),
                        'program' => "RECEIPT",
                        'userid' => auth()->user()->username
                    ]);
                    //dd($masterhistory);
                    $masterhistory->save();
                }
            }    

            DB::connection('mysql')->commit();
            }catch (\Exception $e) {
                //dd('KAWKOKOAKOWKOEA');
                //dd($e->message);
                //report($e->getMessage());
                {DB::rollBack();
                return redirect('/itemTransaksi/index')->with('error', $e->getMessage());
                
            }  
        } 
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
        $um = Masterum::where('um', $request->um)->first();
        $ceklokasi = MasterLokasi::where('id', $request->id_lokasi)->first();
        $barang = MasterBarang::all('id', 'kodeBarang');
        $lokasi = MasterLokasi::all('id', 'kodeLokasi');
        if(!$ceklokasi)
        {
            return redirect()->back()->withInput([
                   
                'id_lokasi' => $request->id_lokasi,
                'id_kodebarang' => $request->id_kodebarang,
                'namaBarang'=> $request->namaBarang,
                'id_um' => $um->id,
                'qty' => $request->qty,
                'tgl_masuk' => Carbon::createFromFormat('d/m/Y', $request->tgl_masuk)->format('Y-m-d H:i:s'),
                'barang'=> $barang,
                'lokasi' => $lokasi

            ])->with( 'error', 'ERROR, Data tidak ada !');
            // return redirect('/itemTransaksi/index')->with('error','ERROR, Data Kode Lokasi tidak ditemukan !');
        }
        $cekbarang = MasterBarang::where('id', $request->id_kodebarang)->first();
        if(!$cekbarang)
        {
            return redirect()->back()->withInput([
                   
                'id_lokasi' => $request->id_lokasi,
                'id_kodebarang' => $request->id_kodebarang,
                'namaBarang'=> $request->namaBarang,
                'id_um' => $um->id,
                'qty' => $request->qty,
                'tgl_masuk' => Carbon::createFromFormat('d/m/Y', $request->tgl_masuk)->format('Y-m-d H:i:s'),
                'barang'=> $barang,
                'lokasi' => $lokasi

            ])->with( 'error', 'ERROR, Data kode barang tidak ada !');
            //return redirect('/itemTransaksi/index')->with('error','ERROR, Data Kode Barang tidak ditemukan !');
        }
        //dd($request);
        //CEK TRANSAKSI TERAKIR YANG ADA TAMBAHNYA WHERE BUKTI LIKE TAMBAH AND SORT BY DATE DESC
        //AMBIL VALUE PERTAMA
        //LALU JALANKAN TAMBAH 0 DAN VALUE
        //REQUEST->BUKTI = BARU
        // $valid = itemTransaksi::where('kodeBarang', $request->kodeBarang)->where('loc_site', $request->loc_site)
        // ->latest()->first();
        // $mastertransaksi = itemTransaksi::where('id_kodebarang', $request->id_kodebarang)->
        // where('id_lokasi', $request->id_lokasi)->latest()->first();
        $Masterstok = Masterstok::where('id_kodebarang', $request->id_kodebarang)->
        where('id_lokasi', $request->id_lokasi)->latest()->first();
        //dd($Masterstok);
        if($Masterstok != null)
        {
          
            // VALIDASI BUY KECUALI LOKSI NYA BEDA ? DAN BARANG BEDA ? udh ok
            if(strtotime(Carbon::createFromFormat('d/m/Y', $request->tgl_masuk)->format('Y-m-d H:i:s')) <= strtotime($Masterstok->tgl_masuk))
            {
               
                return redirect()->back()->withInput([
                   
                    'id_lokasi' => $request->id_lokasi,
                    'id_kodebarang' => $request->id_kodebarang,
                    'namaBarang'=> $request->namaBarang,
                    'id_um' => $um->id,
                    'qty' => $request->qty,
                    'tgl_masuk' => Carbon::createFromFormat('d/m/Y', $request->tgl_masuk)->format('Y-m-d H:i:s'),
                    'barang'=> $barang,
                    'lokasi' => $lokasi
    
                ])->with( 'error', 'ERROR, Sudah ada data penjualan sesudah hari ini !');
                //return redirect('/itemTransaksi/index')->with('error','ERROR, Tanggal masuk Pembelian/Penjualan !');
                dd('masuk sini');
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
                    
                ]);
                // KLO GA VALID ERROR DATA TIDAK VALID ? 
            }
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
            //GET ID FROM TABLE UM
           
            
            DB::connection('mysql')->beginTransaction();
            try{
                $insert = new itemTransaksi([
                    'bukti' => $buktikurang,
                    'id_lokasi' => $request->id_lokasi,
                    'id_kodebarang' => $request->id_kodebarang,
                    'namaBarang' => $request->namaBarang,
                    'id_um' => $um->id,
                    'qty' => $request->qty,
                    'tgl_masuk' => Carbon::createFromFormat('d/m/Y', $request->tgl_masuk)->format('Y-m-d H:i:s'),   
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                $insert->save();
               
                
                // DB::connection('mysql')->commit();
                //dd($buktikurang);
                //DB UPDATE LOCK FOR UPDATE
                // $cekdata = Masterstok::where('tgl_masuk', '=' , Carbon::createFromFormat('d/m/Y', $request->tgl_masuk)->format('Y-m-d H:i:s'))
                // ->first();
                // dd($cekdata);
                $itemstok = Masterstok::where('tgl_masuk', '<=' , Carbon::createFromFormat('d/m/Y', $request->tgl_masuk)->format('Y-m-d H:i:s'))
                ->where('id_kodebarang', $request->id_kodebarang)->where('id_lokasi', $request->id_lokasi)->where('qty' ,'>=', 0 )->lockForUpdate()->orderBy('tgl_masuk', 'ASC')->get();
                if(!$itemstok)
                {
                    return redirect()->back()->withInput([
                   
                        'id_lokasi' => $request->id_lokasi,
                        'id_kodebarang' => $request->id_kodebarang,
                        'namaBarang'=> $request->namaBarang,
                        'id_um' => $um->id,
                        'qty' => $request->qty,
                        'tgl_masuk' => Carbon::createFromFormat('d/m/Y', $request->tgl_masuk)->format('Y-m-d H:i:s'),
                        'barang'=> $barang,
                        'lokasi' => $lokasi
        
                    ])->with( 'error', 'ERROR, Tidak ada stok barang ini !');
                }   
                //dd('qeqweqweqeqw');
                $totalstok = Masterstok::where('tgl_masuk', '<=' , Carbon::createFromFormat('d/m/Y', $request->tgl_masuk)->format('Y-m-d H:i:s'))
                ->where('id_kodebarang', $request->id_kodebarang)->where('id_lokasi', $request->id_lokasi)->sum('qty');
                //dd($totalstok);
                //dapet data all itemstok 
                //dd($itemstok); => udah dapet 4 item data
                $temp = 0;
                //$qty = 0;
            
                if($totalstok < $request->qty) {
                    return redirect('/itemTransaksi/index')->with('error','ERROR, Stok untuk penjualan tidak cukup !');
                }
                else {
                    $sisa = 0;
                    $qty = $request->qty; //100
                    $tampungs = 0;
                    $temp = $qty; //$temp = 100 karena sama dengan qty
                    foreach ($itemstok as $item) {
                        if ($qty > 0) { // klo lbh besar dari 0
                            $qty = $qty - $item->qty;
                                //100 - item qtynya
                            $itemQty = $item->qty;
                            //tampung item qty nya
                            //dd($itemQty);
                            if ($qty > 0) {     // klo misal masih lebih besar 0
                                $sisa = $request->qty - $item->qty; //tampung sisa dari penjualan
                                // dd($sisa);
                                $stok_update = 0;   
                                $tampungs = $qty; // nampung sisa pengurangan
                                $item->qty = $stok_update; //brarti stock di for pertama abis
                                $item->save();
                                // dd($item->qty);
                                //dd('qeqweqweqeqw');
                                $masterhistory = new Masterhistory([
                                    
                                    'bukti' => $buktikurang,
                                    'tgl_trans' => Carbon::createFromFormat('d/m/Y', $request->tgl_masuk)->format('Y-m-d H:i:s'),
                                    'id_lokasi' => $request->id_lokasi,  
                                    'id_kodebarang' => $request->id_kodebarang,
                                    'id_um' => $um->id,
                                    'qty' =>  $item->qty > 0 ? $item->qty : '-'.$itemQty , // hasilnya pasti - dari penjualan
                                    'tgl_masuk' => Carbon::createFromFormat('d/m/Y', $request->tgl_masuk)->format('Y-m-d H:i:s'),
                                    'program' => "ISSUE",
                                    'userid' => auth()->user()->username
                                ]);
                                //update history
                            } else {
                                //dd($qty, $sisa, $tampungs, $itemQty);
                                if($sisa == 0)
                                {
                                    $tampungs = $request->qty;
                                }
                                $sisa = $sisa - abs($qty);
                                
                                $item->qty = abs($qty);
                                $item->save();
                                //dd($tampungs, $item->qty, $qty);
                                $masterhistory = new Masterhistory([
                                    'bukti' => $buktikurang,
                                    'tgl_trans' => Carbon::createFromFormat('d/m/Y', $request->tgl_masuk)->format('Y-m-d H:i:s'),
                                    'id_lokasi' => $request->id_lokasi,  
                                    'id_kodebarang' => $request->id_kodebarang,
                                    'id_um' => $um->id,
                                    'qty' =>  $item->qty > 0 ? '-'.$tampungs : '-'.$itemQty ,
                                    'tgl_masuk' => Carbon::createFromFormat('d/m/Y', $request->tgl_masuk)->format('Y-m-d H:i:s'),
                                    'program' => "ISSUE",
                                    'userid' => auth()->user()->username
                                ]);
                                
                            }                 
                            $masterhistory->save();
                        }
                        
                        else{
                            break;
                        }
                    }
                }
            DB::connection('mysql')->commit();
            }catch (\Exception $e) {
                DB::rollBack();
                return redirect('/itemTransaksi/index')->with('error', $e->getMessage());
                
            }
        }  
        return redirect('/itemTransaksi/index')->with('success','Data Berhasil ditambah');
    }
    public function show(itemTransaksi $itemTransaksi)
    {
        $itemTransaksi = itemTransaksi::where('bukti','LIKE','%'.$request->bukti.'%')->get();
        return view('/Masterstok/index', 
        [
            'title' => 'Master Transaksi',
            "kunci" =>$request->bukti,
            'itemTransaksi'=> $itemTransaksi
        ]);
    }
}
