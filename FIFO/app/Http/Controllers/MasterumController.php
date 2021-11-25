<?php

namespace App\Http\Controllers;

use App\Masterum;
use Illuminate\Http\Request;

class MasterumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $masterum =  Masterum::All();
        return view('/Masterum/index', 
        [
            'title' => 'Master UM',
            "active" =>'masterum',
            'masterum'=> $masterum
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('/Masterum/addum');
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
            'name' => 'required|unique:masterums',
            'um' =>'required|regex:/^[a-zA-Z]+$/u|min:2|unique:masterums'
        ]);
       $masterum = Masterum::where('name', $request->name)->where('um', $request->um)->first();
       if(!$masterum)
       {
            Masterum::create($validatedData);
       }
       else
       {
            return redirect('/Masterum/index')->with('error','Data tidak boleh sama');
       }
      
       return redirect('/Masterum/index')->with('success','Data Berhasil ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Masterum  $masterum
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $masterum = Masterum::where('um','LIKE','%'.$request->um.'%')->get();
        return view('/Masterum/index', 
        [
            'title' => 'Master UM',
            "kunci" =>$request->um,
            'masterum'=> $masterum
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Masterum  $masterum
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editdata =  Masterum::All()->firstWhere('id', $id);
        return view('/Masterum/editum', 
        [
            'title' => "Data edit : $editdata->um",
            "active" =>'editdata',
            'masterum'=> $editdata
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Masterum  $masterum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Masterum $masterum)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:masterums',
            'um' =>'required|regex:/^[a-zA-Z]+$/u|min:2|unique:masterums'
            ]);
            Masterum::where('id',$request->id)->update([
            'name' => $request->name,
            'um' => $request->um
            ]);
            //$request->session()->flash('success','Registration Success');
            return redirect('/Masterum/index')->with('success','Data Berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Masterum  $masterum
     * @return \Illuminate\Http\Response
     */
    public function destroy(Masterum $masterum)
    {
        //
    }
}
