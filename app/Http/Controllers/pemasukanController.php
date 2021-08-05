<?php

namespace App\Http\Controllers;

use App\Models\pemasukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class pemasukanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        #WAJIB
        $pages='pemasukan';
        $jmldata='0';
        $datas='0';


        $datas=pemasukan::all();
        // $kategori=kategori::all();
        $kategori = DB::table('kategori')->where('prefix','pemasukan')->get();
        $jmldata = DB::table('pemasukan')->count();

        return view('admin.pemasukan.index',compact('pages','jmldata','datas','kategori'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'=>'required',
            // 'catatan'=>'required',
            'kategori_nama'=>'required',

        ],
        [
            'nama.required'=>'Nama harus diisi',

        ]);
            // dd($request);
        pemasukan::create($request->all());
        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');
   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pemasukan  $pemasukan
     * @return \Illuminate\Http\Response
     */
    public function show(pemasukan $pemasukan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pemasukan  $pemasukan
     * @return \Illuminate\Http\Response
     */
    public function edit(pemasukan $pemasukan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\pemasukan  $pemasukan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pemasukan $pemasukan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pemasukan  $pemasukan
     * @return \Illuminate\Http\Response
     */
    public function destroy(pemasukan $pemasukan)
    {
        //
    }
}
