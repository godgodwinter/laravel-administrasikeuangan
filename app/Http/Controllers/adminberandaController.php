<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminberandaController extends Controller
{
    public function index()
    {
        $pages='beranda';
        $siswa = DB::table('siswa')->count();
        $kelas = DB::table('kelas')->count();
        $pemasukan = DB::table('pemasukan')->count();
        //lunas
        $lunas=0;
        $belumlunas=0;


        $counttagihansiswa = DB::table('tagihansiswa')
        ->count();
        // 1.ambil tagihansiswa >nominal , ambil total tagihansiswadetail where id
            $gettagihansiswa = DB::table('tagihansiswa')
            ->get();
            foreach ($gettagihansiswa as $ts){
                $tagihansiswa_id=$ts->id;

            $sumdetailbayar = DB::table('tagihansiswadetail')
            ->where('tagihansiswa_id', '=', $ts->id)
            ->sum('nominal');

            // dd($sumdetailbayar);
                $kurang=$ts->nominaltagihan-$sumdetailbayar;
                if($kurang<=0){
                    $lunas+=1;
                }
            }
            $belumlunas=$counttagihansiswa-$lunas;
            // dd($gettagihansiswa);
        

            $ttlpemasukan = DB::table('pemasukan')
            // ->where('tagihansiswa_id', '=', $ts->id)
            ->sum('nominal');

            $ttlpengeluaran = DB::table('pengeluaran')
            // ->where('tagihansiswa_id', '=', $ts->id)
            ->sum('nominal');

            $saldo=$ttlpemasukan-$ttlpengeluaran;


        return view('admin.beranda',compact('pages'
        ,'pemasukan'
        ,'kelas'
        ,'siswa','lunas','belumlunas','ttlpemasukan','ttlpengeluaran','saldo'));
        // return view('admin.beranda');


            // $sumdetailbayar = DB::table('tagihansiswadetail')
            // ->where('tagihansiswa_id', '=', $tagihansiswa->id)
            // ->sum('nominal');
    }
}
