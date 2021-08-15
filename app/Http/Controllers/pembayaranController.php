<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use App\Models\kelas;
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
        $jmldata = DB::table('tagihanatur')->count();

        return view('admin.pembayaran.index',compact('pages','jmldata','datas','tapel','kelas','request'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'=>'required',
            'tipe'=>'required',
            'defaultvalue'=>'required'

        ],
        [
            'nama.required'=>'Nama Harus diisi',

        ]);
            // dd($request);

       DB::table('kategori')->insert(
        array(
               'nama'     =>   $request->nama,
               'tipe'     =>   $request->tipe,
               'defaultvalue'     =>   $request->defaultvalue,
               'prefix'     =>   'tagihan',
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));
        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');
    }

    public function destroy(kategori $pembayaran)
    {
        // dd($pembayaran);
        kategori::destroy($pembayaran->id);
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

        return view('admin.pembayaran.edit',compact('pages','jmldata','datas','pembayaran'));
    }

    public function update(Request $request, kategori $pembayaran)
    {
        // dd($tapel);
        
        $request->validate([
            'nama'=>'required',
            'defaultvalue'=>'required|numeric',
            'tipe'=>'required',
        ],
        [
            'nama.required'=>'Nama Harus diisi',


        ]);
         //aksi update

        kategori::where('id',$pembayaran->id)
            ->update([
                'nama'=>$request->nama,
                'defaultvalue'=>$request->defaultvalue,
                'tipe'=>$request->tipe,
            ]);
            return redirect()->back()->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }

}
