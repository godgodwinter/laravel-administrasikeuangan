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
        $databos=DB::table('pemasukan')->where('kategori_nama','Dana Bos')->get();
        $pengeluaranbos=DB::table('pengeluaran')->where('kategori_nama','Dana Bos')->get();
        $datapemasukan=DB::table('pemasukan')->whereNotIn('kategori_nama', ['Dana Bos'])->get();
        $datapengeluaran=DB::table('pengeluaran')->whereNotIn('kategori_nama', ['Dana Bos'])->get();
        // dd($datapengeluaran);

        $pdf = PDF::loadview('admin.laporan.cetak',compact('databos','pengeluaranbos','datapemasukan','datapengeluaran'))->setPaper('a4', 'potrait');
        return $pdf->download('laporansekolah_'.$tgl.'-pdf');
    }


    public function cetakbln($bln)
    {
        $tgl=date("YmdHis");
        $bln=$bln;
        $month = date("m",strtotime($bln));
        $year = date("Y",strtotime($bln));
        // dd($tgl);
        $databos=DB::table('pemasukan')->where('kategori_nama','Dana Bos')->whereMonth('tglbayar',$month)->whereYear('tglbayar',$year)->get();
        $pengeluaranbos=DB::table('pengeluaran')->where('kategori_nama','Dana Bos')->whereMonth('tglbayar',$month)->whereYear('tglbayar',$year)->get();
        $datapemasukan=DB::table('pemasukan')->whereNotIn('kategori_nama', ['Dana Bos'])->whereMonth('tglbayar',$month)->whereYear('tglbayar',$year)->get();
        $datapengeluaran=DB::table('pengeluaran')->whereNotIn('kategori_nama', ['Dana Bos'])->whereMonth('tglbayar',$month)->whereYear('tglbayar',$year)->get();
        // dd($datapengeluaran);

        $pdf = PDF::loadview('admin.laporan.cetakbln',compact('databos','pengeluaranbos','datapemasukan','datapengeluaran','month','year','bln'))->setPaper('a4', 'potrait');
        return $pdf->download('laporansekolah_'.$tgl.'-pdf');
    }
}
