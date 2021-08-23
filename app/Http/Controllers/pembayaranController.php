<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use App\Models\kelas;
use App\Models\pembayaran;
use App\Models\tapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class pembayaranController extends Controller
{
    public function index(Request $request)
    {
        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        #WAJIB
        $pages='pembayaran';
        $jmldata='0';
        $datas='0';


        $tapel=tapel::all();
        $kelas=kelas::all();
        $datas=DB::table('kategori')->where('prefix','tagihan')->orderBy('tipe','asc')
        ->get();

        // $datas=DB::table('kategori')->where('prefix','tagihan')->orderBy('tipe','asc')
        // ->paginate($this->paginationjml());
        // // $tagihanatur=tagihanatur::all();
        // $tagihanatur = DB::table('tagihanatur')->where('prefix','tagihanatur')->get();
        $jmldata = DB::table('kategori')->where('prefix','tagihan')->count();
        $tapelaktif=$this->tapelaktif();
        $semesteraktif=$this->semesteraktif();

        return view('admin.pembayaran.index',compact('pages','jmldata','datas','tapel','kelas','request','tapelaktif','semesteraktif'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'=>'required',
            'tipe'=>'required',
            'defaultvalue'=>'required|numeric|min:10000'

        ],
        [
            'nama.required'=>'Nama Harus diisi',

        ]);


        if($request->semester==='Semester 1'){
            $bln=$this->semester1bln();
        }else{
            $bln=$this->semester2bln();
        }

        $cekkategoritagihan=DB::table('kategori')->where('tapel_nama',$request->tapel_nama)->where('nama',$request->nama)
        ->count();

            // dd($request);
        if($cekkategoritagihan>0){

        kategori::where('nama',$request->nama)->where('tapel_nama',$request->tapel_nama)
        ->update([
            'nama'=>$request->nama,
            'defaultvalue'=>$request->defaultvalue,
            'tipe'=>$request->tipe,
            'semester'     =>   $request->semester,
            'tapel_nama'     =>   $request->tapel_nama,
            'bln'     =>   $bln,
        ]);

        }else{

       DB::table('kategori')->insert(
        array(
               'nama'     =>   $request->nama,
               'tipe'     =>   $request->tipe,
               'defaultvalue'     =>   $request->defaultvalue,
               'semester'     =>   $request->semester,
               'tapel_nama'     =>   $request->tapel_nama,
               'prefix'     =>   'tagihan',
               'semester'     =>   $request->semester,
               'tapel_nama'     =>   $request->tapel_nama,
               'bln'     =>   $bln,
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));

        }

        //ambil siswa aktif di tapel sekarang
        $datasiswas=DB::table('siswa')->where('tapel_nama',$request->tapel_nama)
        ->get();


        foreach($datasiswas as $ds){
            $nis=$ds->nis;
            $nama=$ds->nama;
            // $kelas_nama=$ds->kelas_nama;
            $tapel_nama=$ds->tapel_nama;
            

        $cekpembayaransiswa=DB::table('pembayaran')->where('tapel_nama',$request->tapel_nama)->where('namatagihan',$request->nama)
        ->where('siswa_nis',$nis)
        ->count();
        if($cekpembayaransiswa>0){
            // jika sudah ada apdet
        pembayaran::where('namatagihan',$request->nama)->where('tapel_nama',$request->tapel_nama)->where('siswa_nis',$nis)
        ->update([
           'namatagihan'     =>   $request->nama,
           'tipe'     =>   $request->tipe,
           'tapel_nama'     =>   $request->tapel_nama,
           'semester'     =>   $request->semester,
           'bln'     =>   $bln,
           'nominaltagihan'     =>   $request->defaultvalue,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);
// dd('update');
        // DB::table('pembayaran')
        // ->whereIn('namatagihan', $request->nama)
        // ->whereIn('tapel_nama', $request->tapel_nama)
        // ->whereIn('siswa_nis', $nis)
        // ->update(array(
        //     'tipe'     =>   $request->tipe,
        //     'tapel_nama'     =>   $request->tapel_nama,
        //     'semester'     =>   $request->semester,
        //     'bln'     =>   $bln,
        //     'nominaltagihan'     =>   $request->defaultvalue,
        //     'updated_at'=>date("Y-m-d H:i:s")
        //  ));

        }else{
            //jika belum ada insert
       DB::table('pembayaran')->insert(
        array(
               'siswa_nis'     =>   $nis,
               'siswa_nama'     =>   $nama,
               'namatagihan'     =>   $request->nama,
               'nominaltagihan'     =>   $request->defaultvalue,
               'tipe'     =>   $request->tipe,
               'semester'     =>   $request->semester,
               'tapel_nama'     =>   $request->tapel_nama,
               'bln'     =>   $bln,
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));

        }
            

        }

        
        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');
    }

    public function destroy(kategori $pembayaran)
    {
        DB::table('pembayaran')->where('namatagihan', $pembayaran->nama)->where('tapel_nama',$pembayaran->tapel_nama)->delete();
        // dd($pembayaran);
        kategori::destroy($pembayaran->id);

        DB::table('pembayaran')->where('namatagihan', $pembayaran->nama)->where('tapel_nama',$pembayaran->tapel_nama)->delete();
        // pembayaran::where('namatagihan',$request->nama)->where('tapel_nama',$request->tapel_nama)->where('siswa_nis',$nis)
        // pembayaran::destroy($pembayaran->id);

        return redirect(URL::to('/').'/admin/pembayaran')->with('status','Data berhasil dihapus!')->with('tipe','danger')->with('icon','fas fa-trash');
    
    }

    public function show(kategori $pembayaran)
    {
        #WAJIB
        $pages='pembayaran';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('kategori')->where('prefix','tagihan')->orderBy('tipe','asc')
        ->get();
        // // $kategori=kategori::all();
        // $kategori = DB::table('kategori')->where('prefix','kategori')->get();
        $jmldata = DB::table('kategori')->count();
        $tapelaktif=$this->tapelaktif();
        $semesteraktif=$this->semesteraktif();

        $tapel=tapel::all();

        return view('admin.pembayaran.edit',compact('pages','jmldata','datas','pembayaran','tapelaktif','semesteraktif','tapel'));
    }

    public function update(Request $request, kategori $pembayaran)
    {
        // dd($tapel);
        
        $request->validate([
            'nama'=>'required',
            'defaultvalue'=>'required|numeric|min:10000',
            'tipe'=>'required',
        ],
        [
            'nama.required'=>'Nama Harus diisi',


        ]);
         //aksi update

        if($request->semester==='Semester 1'){
            $bln=$this->semester1bln();
        }else{
            $bln=$this->semester2bln();
        }

        kategori::where('id',$pembayaran->id)
            ->update([
                'nama'=>$request->nama,
                'defaultvalue'=>$request->defaultvalue,
                'tipe'=>$request->tipe,
                'semester'     =>   $request->semester,
                'tapel_nama'     =>   $request->tapel_nama,
                'bln'     =>   $bln,
            ]);



        //ambil siswa aktif di tapel sekarang
        $datasiswas=DB::table('siswa')->where('tapel_nama',$request->tapel_nama)
        ->get();


        foreach($datasiswas as $ds){
            $nis=$ds->nis;
            $nama=$ds->nama;
            // $kelas_nama=$ds->kelas_nama;
            $tapel_nama=$ds->tapel_nama;
            

        $cekpembayaransiswa=DB::table('pembayaran')->where('tapel_nama',$request->tapel_nama)->where('namatagihan',$request->nama)
        ->where('siswa_nis',$nis)
        ->count();
        if($cekpembayaransiswa>0){
            // jika sudah ada apdet
        pembayaran::where('namatagihan',$request->nama)->where('tapel_nama',$request->tapel_nama)->where('siswa_nis',$nis)
        ->update([
           'namatagihan'     =>   $request->nama,
           'tipe'     =>   $request->tipe,
           'tapel_nama'     =>   $request->tapel_nama,
           'semester'     =>   $request->semester,
           'bln'     =>   $bln,
           'nominaltagihan'     =>   $request->defaultvalue,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);
// dd('update');
        // DB::table('pembayaran')
        // ->whereIn('namatagihan', $request->nama)
        // ->whereIn('tapel_nama', $request->tapel_nama)
        // ->whereIn('siswa_nis', $nis)
        // ->update(array(
        //     'tipe'     =>   $request->tipe,
        //     'tapel_nama'     =>   $request->tapel_nama,
        //     'semester'     =>   $request->semester,
        //     'bln'     =>   $bln,
        //     'nominaltagihan'     =>   $request->defaultvalue,
        //     'updated_at'=>date("Y-m-d H:i:s")
        //  ));

        }else{
            //jika belum ada insert
       DB::table('pembayaran')->insert(
        array(
               'siswa_nis'     =>   $nis,
               'siswa_nama'     =>   $nama,
               'namatagihan'     =>   $request->nama,
               'nominaltagihan'     =>   $request->defaultvalue,
               'tipe'     =>   $request->tipe,
               'semester'     =>   $request->semester,
               'tapel_nama'     =>   $request->tapel_nama,
               'bln'     =>   $bln,
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));

        }
            

        }



            return redirect()->back()->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }

}
