<?php

namespace App\Http\Controllers;

use App\Models\kelas;
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
    public function index()
    {
        #WAJIB
        $pages='siswa';
        $jmldata='0';
        $datas='0';


        $datas=siswa::all();
        $tapel=tapel::all();
        $kelas=kelas::all();
        $jmldata = DB::table('siswa')->count();

        return view('admin.siswa.index',compact('pages','jmldata','datas','tapel','kelas'));
        // return view('admin.beranda');
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
        
        return redirect(URL::to('/').'/admin/siswa')->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function show(siswa $siswa)
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

        return view('admin.siswa.edit',compact('pages','jmldata','datas','tapel','kelas','siswa','datausers'));
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

            return redirect('/admin/siswa')->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
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
}
