<?php

namespace App\Http\Controllers;

use App\Models\kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class laporanController extends Controller
{
    public function index()
    {
        #WAJIB
        $pages='kelas';
        $jmldata='0';
        $datas='0';


        $datas=kelas::all();

        $jmldata = DB::table('kelas')->count();

        return view('admin.kelas.index',compact('pages','jmldata','datas'));
        // return view('admin.beranda');
    }
}
