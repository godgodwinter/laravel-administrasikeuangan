<?php

namespace App\Http\Controllers;

use App\Models\kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Carbon\Carbon;

class laporanController extends Controller
{
    public function index()
    {
        #WAJIB
        $pages='laporan';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('kelas')
        ->paginate($this->paginationjml());

        $jmldata = DB::table('kelas')->count();

        return view('admin.laporan.index',compact('pages','jmldata','datas'));
    }

    public function cetak()
    {
        $tgl=date("YmdHis");
        // dd($tgl);
        $datas=DB::table('kelas')
        ->paginate($this->paginationjml());

        $pdf = PDF::loadview('admin.laporan.cetak',compact('datas'))->setPaper('a4', 'potrait');
        return $pdf->download('laporansekolah_'.$tgl.'-pdf');
    }
}
