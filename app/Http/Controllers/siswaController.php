<?php

namespace App\Http\Controllers;

use App\Models\kelas;
use App\Models\pembayaran;
use App\Models\pembayarandetail;
use App\Models\siswa;
use App\Models\tapel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class siswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        #WAJIB
        $pages='siswa';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('siswa')->where('tapel_nama',$this->tapelaktif())
        ->paginate($this->paginationjml());
    
        $tapel=tapel::all();
        $kelas=kelas::all();
        $jmldata = DB::table('siswa')->count();

        return view('admin.siswa.index',compact('pages','jmldata','datas','tapel','kelas','request'));
        // return view('admin.beranda');
    }
    public function datasiswaindex(Request $request,siswa $siswa)
    {
        // dd($siswa);
        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        #WAJIB
        $pages='siswa';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('pembayaran')->where('siswa_nis',$siswa->nis)
        ->where('tapel_nama',$this->tapelaktif())
        // ->where('semester',$this->semesteraktif())
        ->get();
    
        $tapel=tapel::all();
        $kelas=kelas::all();
        $jmldata = DB::table('siswa')->count();

        $tapelaktif=$this->tapelaktif();
        $semesteraktif=$this->semesteraktif();

        return view('admin.siswa.datasiswa',compact('pages','jmldata','datas','tapel','kelas','request','siswa','tapelaktif','semesteraktif'));
        // return view('admin.beranda');
    }

    public function cari(Request $request)
    {
        // dd($request);
        $cari=$request->cari;
        $tapel_nama=$request->tapel_nama;
        $kelas_nama=$request->kelas_nama;

        #WAJIB
        $pages='siswa';
        $jmldata='0';
        $datas='0';


    $datas=DB::table('siswa')
    // ->where('nis','like',"%".$cari."%")
    ->where('nama','like',"%".$cari."%")
    ->where('tapel_nama','like',"%".$tapel_nama."%")
    ->where('kelas_nama','like',"%".$kelas_nama."%")
    ->orWhere('nis','like',"%".$cari."%")
    ->where('tapel_nama','like',"%".$tapel_nama."%")
    ->where('kelas_nama','like',"%".$kelas_nama."%")
    ->paginate($this->paginationjml());

        // $kategori=kategori::all();
        $tapel=tapel::all();
        $kelas=kelas::all();
        $jmldata = DB::table('siswa')->count();


        return view('admin.siswa.index',compact('pages','jmldata','datas','tapel','kelas','request'));
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
            'tempatlahir'=>'required',
            'tgllahir'=>'required',
            'agama'=>'required',
            'alamat'=>'required',
            'tapel_nama'=>'required',
            'kelas_nama'=>'required',
            'nis' => 'required|unique:siswa',
            'email' => 'required|email|unique:users',
            'password' => 'min:8|required_with:password2|same:password2',
            'password2' => 'min:8',

        ],
        [
            'nis.unique'=>'NIS sudah digunakan',
            'password.same'=>'Password dan Konfirmasi Password berbeda',

        ]);

        //inser siswa
       DB::table('siswa')->insert(
        array(
               'nis'     =>   $request->nis,
               'nama'     =>   $request->nama,
               'tempatlahir'     =>   $request->tempatlahir,
               'tgllahir'     =>   $request->tgllahir,
               'agama'     =>   $request->agama,
               'alamat'     =>   $request->alamat,
               'tapel_nama'     =>   $request->tapel_nama,
               'kelas_nama'     =>   $request->kelas_nama,
               'hp'     =>   $request->hp,
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));
        //insert users
       DB::table('users')->insert(
        array(
               'nomerinduk'     =>   $request->nis,
               'name'     =>   $request->nama,
               'password' => Hash::make($request->password),
               'tipeuser'     =>   'siswa',
               'email'     =>   $request->email,
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));
        
        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');
    
    }

    public function datasiswastore(Request $request,siswa $siswa)
    {
        $request->validate([
            'namatagihan'=>'required',
            'tipe'=>'required',
            'tapel_nama'=>'required',
            'semester'=>'required',
            'nominaltagihan'=>'required|numeric|min:1000',

        ],
        [
            'nama.required'=>'nama harus diisi',

        ]);

        if($request->semester==='Semester 1'){
            $bln=$this->semester1bln();
        }else{
            $bln=$this->semester2bln();
        }
        //inser siswa
       DB::table('pembayaran')->insert(
        array(
               'siswa_nis'     =>   $siswa->nis,
               'siswa_nama'     =>   $siswa->nama,
               'namatagihan'     =>   $request->namatagihan,
               'nominaltagihan'     =>   $request->nominaltagihan,
               'tipe'     =>   $request->tipe,
               'semester'     =>   $request->semester,
               'tapel_nama'     =>   $request->tapel_nama,
               'bln'     =>   $bln,
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));
        
        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');
    
    }

    public function datasiswabayar(Request $request,pembayaran $pembayaran)
    {
        // dd($request->bln);
        
        $request->validate([
            'nominal'=>'required|numeric',

        ],
        [
            'nominal.required'=>'nominal harus diisi',

        ]);

        if($pembayaran->tipe==='perbulan'){
            $bln=$request->bln;
        }else{
            $bln='';
        }
        //inser siswa
       DB::table('pembayarandetail')->insert(
        array(
               'pembayaran_id'     =>   $pembayaran->id,
               'nominal'     =>   $request->nominal,
               'tglbayar'     =>   date("Y-m-d H:i:s"),
               'bln'     =>   $bln,
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));
        
        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,siswa $siswa)
    {
        #WAJIB
        $pages='siswa';
        $jmldata='0';
        $datas='0';


        $datas=siswa::all();
        $tapel=tapel::all();
        $kelas=kelas::all();
        $jmldata = DB::table('siswa')->count();
        $datausers = DB::table('users')->where('nomerinduk',$siswa->nis)->get();

        return view('admin.siswa.edit',compact('pages','jmldata','datas','tapel','kelas','siswa','datausers','request'));
    }

    public function datasiswashow(Request $request,pembayaran $pembayaran)
    {
        #WAJIB
        $pages='siswa';
        $jmldata='0';
        $datas='0';


        $datas=siswa::all();
        $tapel=tapel::all();
        $kelas=kelas::all();
        $jmldata = DB::table('siswa')->count();

        $tapelaktif=$this->tapelaktif();
        $semesteraktif=$this->semesteraktif();

        return view('admin.siswa.datasiswaedit',compact('pages','jmldata','datas','tapel','kelas','pembayaran','request','tapelaktif','semesteraktif'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function edit(siswa $siswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, siswa $siswa)
    { 
        // dd($siswa->nis);
        $datausers = DB::table('users')->where('nomerinduk',$siswa->nis)->get();
        foreach($datausers as $d){
            $emailku=$d->id;
        }
        // dd($emailku);

        $request->validate([
            'nama'=>'required',
            'tempatlahir'=>'required',
            'tgllahir'=>'required',
            'agama'=>'required',
            'alamat'=>'required',
            'tapel_nama'=>'required',
            'kelas_nama'=>'required',
            'nis' => 'required|unique:siswa,nis,'.$siswa->id,
            'email' => 'unique:users,email,'.$emailku,
        ],
        [
            'nis.unique'=>'NIS sudah digunakan',
            // 'password.same'=>'Password dan Konfirmasi Password berbeda',

        ]);

        if(!empty($request->password)){

        $request->validate([
           
            'password' => 'min:8|required_with:password2|same:password2',
            'password2' => 'min:8',

        ],
        [
           
            'password.same'=>'Password dan Konfirmasi Password berbeda',

        ]);

        }
         //aksi update

        siswa::where('id',$siswa->id)
            ->update([
               'nis'     =>   $request->nis,
               'nama'     =>   $request->nama,
               'tempatlahir'     =>   $request->tempatlahir,
               'tgllahir'     =>   $request->tgllahir,
               'agama'     =>   $request->agama,
               'alamat'     =>   $request->alamat,
               'tapel_nama'     =>   $request->tapel_nama,
               'kelas_nama'     =>   $request->kelas_nama,
               'hp'     =>   $request->hp,
               'updated_at'=>date("Y-m-d H:i:s")
            ]);


        User::where('nomerinduk',$siswa->nis)
        ->update([
            'name'     =>   $request->nama,
           'nomerinduk'     =>   $request->nis,
           'email'     =>   $request->email,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);

        if(!empty($request->password)){

                    User::where('nomerinduk',$siswa->nis)
                    ->update([
                        'password' => Hash::make($request->password),
                    'updated_at'=>date("Y-m-d H:i:s")
                    ]);

        }

        return redirect()->back()->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }


    public function datasiswaupdate(Request $request, pembayaran $pembayaran)
    { 

        $datasiswa = DB::table('siswa')->where('nis',$pembayaran->siswa_nis)->get();
        foreach($datasiswa as $d){
            $siswaid=$d->id;
        }
        $request->validate([
            'namatagihan'=>'required',
            'tipe'=>'required',
            'tapel_nama'=>'required',
            'semester'=>'required',
            'nominaltagihan'=>'required|numeric',
        ],
        [
            'namatagihan.required'=>'Nama harus diisi',

        ]);


        if($request->semester==='Semester 1'){
            $bln=$this->semester1bln();
        }else{
            $bln=$this->semester2bln();
        }
         //aksi update

        pembayaran::where('id',$pembayaran->id)
            ->update([
               'namatagihan'     =>   $request->namatagihan,
               'tipe'     =>   $request->tipe,
               'tapel_nama'     =>   $request->tapel_nama,
               'semester'     =>   $request->semester,
               'bln'     =>   $bln,
               'nominaltagihan'     =>   $request->nominaltagihan,
               'updated_at'=>date("Y-m-d H:i:s")
            ]);



        return redirect(URL::to('/').'/admin/datasiswa/'.$siswaid)->with('status','Data berhasil diubah!')->with('tipe','success')->with('icon','fas fa-edit');
        // return redirect()->back()->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(siswa $siswa)
    {
        siswa::destroy($siswa->id);
       
        DB::table('users')->where('nomerinduk', $siswa->nis)->delete();
        return redirect(URL::to('/').'/admin/siswa')->with('status','Data berhasil dihapus!')->with('tipe','danger')->with('icon','fas fa-trash');
  
    }

    public function datasiswadestroy(pembayaran $pembayaran)
    {
        $datasiswa = DB::table('siswa')->where('nis',$pembayaran->siswa_nis)->get();
        foreach($datasiswa as $d){
            $siswaid=$d->id;
        }
        pembayaran::destroy($pembayaran->id);
       
        // DB::table('users')->where('nomerinduk', $siswa->nis)->delete();

        return redirect(URL::to('/').'/admin/datasiswa/'.$siswaid)->with('status','Data berhasil hapus!')->with('tipe','danger')->with('icon','fas fa-trash');
     
     
    }

    public function datasiswabayardestroy(pembayarandetail $pembayarandetail)
    {

        $ambilnis = DB::table('pembayaran')->where('id',$pembayarandetail->pembayaran_id)->get();
        foreach($ambilnis as $an){
            $siswanis=$an->siswa_nis;
        }

        $datasiswa = DB::table('siswa')->where('nis',$siswanis)->get();
        foreach($datasiswa as $d){
            $siswaid=$d->id;
        }
        pembayarandetail::destroy($pembayarandetail->id);
       
        // DB::table('users')->where('nomerinduk', $siswa->nis)->delete();

        return redirect(URL::to('/').'/admin/datasiswa/'.$siswaid)->with('status','Data berhasil hapus!')->with('tipe','danger')->with('icon','fas fa-trash');
     
     
    }
}
