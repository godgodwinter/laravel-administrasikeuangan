<?php

namespace App\Http\Controllers;

use App\Models\pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class pengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        #WAJIB
        $pages='pengeluaran';
        $jmldata='0';
        $datas='0';


        $datas=pengeluaran::all();
        // $kategori=kategori::all();
        $kategori = DB::table('kategori')->where('prefix','pengeluaran')->get();
        $jmldata = DB::table('pengeluaran')->count();

        return view('admin.pengeluaran.index',compact('pages','jmldata','datas','kategori'));
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
            'nominal'=>'required|numeric',

        ],
        [
            'nama.required'=>'Nama harus diisi',

        ]);
            // dd($request);
        pengeluaran::create($request->all());
        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function show(pengeluaran $pengeluaran)
    {
        #WAJIB
        $pages='pengeluaran';
        $jmldata='0';
        $datas='0';


        $datas=pengeluaran::all();
        $jmldata = DB::table('pengeluaran')->count();
        $kategori = DB::table('kategori')->where('prefix','pengeluaran')->get();
        return view('admin.pengeluaran.edit',compact('pengeluaran','pages','jmldata','datas','kategori'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function edit(pengeluaran $pengeluaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pengeluaran $pengeluaran)
    {
        $request->validate([
            'nama'=>'required',
            'nominal'=>'required|numeric',
            // 'catatan'=>'required',
            'kategori_nama'=>'required',

        ],
        [
            'nama.required'=>'Nama harus diisi',

        ]);
         //aksi update

        pengeluaran::where('id',$pengeluaran->id)
            ->update([
                'nama'=>$request->nama,
                'catatan'=>$request->catatan,
                'nominal'=>$request->nominal,
                'kategori_nama'=>$request->kategori_nama,
            ]);
            return redirect()->back()->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(pengeluaran $pengeluaran)
    {
        pengeluaran::destroy($pengeluaran->id);
        return redirect(URL::to('/').'/admin/pengeluaran')->with('status','Data berhasil dihapus!')->with('tipe','danger')->with('icon','fas fa-trash');
    
    }
}
