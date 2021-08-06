<?php

namespace App\Http\Controllers;

use App\Models\kelas;
use App\Models\tagihansiswa;
use App\Models\tapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class tagihansiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        #WAJIB
        $pages='tagihanatur';
        $jmldata='0';
        $datas='0';


        $tapel=tapel::all();
        $kelas=kelas::all();
        $datas=DB::table('tagihanatur')->orderBy('tapel_nama','asc')->get();
        // // $tagihanatur=tagihanatur::all();
        // $tagihanatur = DB::table('tagihanatur')->where('prefix','tagihanatur')->get();
        $jmldata = DB::table('tagihanatur')->count();

        return view('admin.tagihansiswa.index',compact('pages','jmldata','datas','tapel','kelas'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tagihansiswa  $tagihansiswa
     * @return \Illuminate\Http\Response
     */
    public function show(tagihansiswa $tagihansiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tagihansiswa  $tagihansiswa
     * @return \Illuminate\Http\Response
     */
    public function edit(tagihansiswa $tagihansiswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tagihansiswa  $tagihansiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tagihansiswa $tagihansiswa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tagihansiswa  $tagihansiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(tagihansiswa $tagihansiswa)
    {
        //
    }
}
