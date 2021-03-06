@extends('layouts.layoutadmin1')

@section('title','Siswa')
@section('halaman','siswa')

@section('csshere')
@endsection

@section('jshere')
@endsection


@section('notif')


@if (session('tipe'))
        @php
        $tipe=session('tipe');
        @endphp
@else
        @php
            $tipe='light';
        @endphp
@endif

@if (session('icon'))
        @php
        $icon=session('icon');
        @endphp
@else
        @php
            $icon='far fa-lightbulb';
        @endphp
@endif

@php
  $message=session('status');
@endphp
@if (session('status'))
<x-alert tipe="{{ $tipe }}" message="{{ $message }}" icon="{{ $icon }}"/>

@endif
@endsection


{{-- DATATABLE --}}
@section('headtable')
  <th width="5%" class="text-center">#</th>
  <th>Nama</th>
  <th>Kelas</th>
  <th>Email</th>
  <th width="150px" class="text-center">Aksi</th>
@endsection

@section('bodytable')
@foreach ($datas as $data)
  <tr>
    <td>{{ ((($loop->index)+1)+(($datas->currentPage()-1)*$datas->perPage())) }}</td>
    <td>{{ $data->nis }} - {{ $data->nama }}</td>
    <td>{{ $data->tapel_nama }} - {{ $data->kelas_nama }}</td>

        @php
        $ambilemail = DB::table('users')
        ->where('nomerinduk', '=', $data->nis)
        ->get();
        @endphp
        @foreach ($ambilemail as $ae)
        @php
          $email=$ae->email;
        @endphp
        @endforeach
    <td> {{ $email }} </td>
    <td class="text-center">
        <a href="/admin/datasiswa/{{$data->id}}" class="btn btn-info btn-sm"><i class="fas fa-search-plus"></i></a>
        <x-button-edit link="/admin/{{ $pages }}/{{$data->id}}" />
        <x-button-delete link="/admin/{{ $pages }}/{{$data->id}}" />
    </td>
  </tr>
@endforeach
@endsection

@section('foottable')
@php
  $cari=$request->cari;
  $tapel_nama=$request->tapel_nama;
  $kelas_nama=$request->kelas_nama;
@endphp
  {{-- {{ $datas->appends(['cari'=>$request->cari,'yearmonth'=>$request->yearmonth,'kategori_nama'=>$request->kategori_nama])->links() }} --}}
  {{ $datas->onEachSide(1)
    ->appends(['cari'=>$cari])
    ->appends(['tapel_nama'=>$tapel_nama])
    ->appends(['kelas_nama'=>$kelas_nama])
    ->links() }}
  <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
      <li class="breadcrumb-item"><i class="far fa-file"></i> Halaman ke-{{ $datas->currentPage() }}</li>
      <li class="breadcrumb-item"><i class="fas fa-paste"></i> {{ $datas->total() }} Total Data</li>
      <li class="breadcrumb-item active" aria-current="page"><i class="far fa-copy"></i> {{ $datas->perPage() }} Data Perhalaman</li>
  </ol>
  </nav>
@endsection

{{-- DATATABLE-END --}}

@section('container')

  <div class="section-body">


    <div class="row ">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
          <div class="card-body">
            <form action="{{ route($pages.'.cari') }}" method="GET">
              <div class="row">
                  <div class="form-group col-md-2 col-2 mt-1 text-right">
                    <input type="text" name="cari" id="cari" class="form-control form-control-sm @error('cari') is-invalid @enderror" value="{{$request->cari}}"  placeholder="Cari...">
                    @error('cari')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-2 col-2 text-right">

                    <select class="form-control form-control-sm" name="tapel_nama" >
                    @if($request->tapel_nama)
                      <option>{{$request->tapel_nama}}</option>
                    @else
                     <option value="" disabled selected>Pilih Tahun Pelajaran</option>
                    @endif
                  @foreach ($tapel as $t)
                      <option>{{ $t->nama }}</option>
                  @endforeach
                </select>
                  </div>
                  <div class="form-group  col-md-2 col-2 text-right">

                  <select class="form-control form-control-sm" name="kelas_nama">
                    @if($request->kelas_nama)
                      <option>{{$request->kelas_nama}}</option>
                    @else
                     <option value="" disabled selected>Pilih Kelas</option>
                    @endif

                @foreach ($kelas as $t)
                    <option>{{ $t->nama }}</option>
                @endforeach
              </select>
                  </div>
              <div class="form-group   text-right">

              <button type="submit" value="CARI" class="btn btn-icon btn-info btn-sm mt-1" ><span
              class="pcoded-micon"> <i class="fas fa-search"></i> Pecarian</span></button>

                  </div>


            </form>
            <div class="form-group col-md-4 col-4 mt-1 text-right">
              <a href="/admin/{{  $pages }}/#add" type="submit" value="CARI" class="btn btn-icon btn-primary btn-sm"><span
                class="pcoded-micon"> <i class="far fa-plus-square"></i> Tambah @yield('title')</span></a href="$add">




              </div>
          </div>
        </div>
      </div>
    </div>
    </div>


    <div class="row mt-sm-0">
      <div class="col-12 col-md-12 col-lg-12">
        <x-layout-table pages="{{ $pages }}" pagination="{{ $datas->perPage() }}"/>
       </div>

      <div class="col-12 col-md-12 col-lg-7" id="add">
        <div class="card">
            <form action="/admin/{{ $pages }}" method="post">
                @csrf
            <div class="card-header">
                <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> TAMBAH {{ Str::upper($pages) }}</span>
            </div>
            <div class="card-body">
                <div class="row">
                  <div class="form-group col-md-6 col-6">
                    <label for="nis">NIS <code>*)</code></label>
                    <input type="number" name="nis" id="nis" class="form-control @error('nis') is-invalid @enderror" value="{{old('nis')}}" required>
                    @error('nis')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label for="nama">Nama <code>*)</code></label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{old('nama')}}" required>
                    @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label for="tempatlahir">Tempat Lahir <code>*)</code></label>
                    <input type="text" name="tempatlahir" id="tempatlahir" class="form-control @error('tempatlahir') is-invalid @enderror" value="{{old('tempatlahir')}}" required>
                    @error('tempatlahir')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label>Tanggal Lahir</label>
                    <input type="date" class="form-control" name="tgllahir" @error('tgllahir') is-invalid @enderror" value="{{old('tgllahir')}}" >
                    @error('tgllahir')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label>Agama <code>*)</code></label>
                    <select class="form-control form-control-lg" required name="agama">
                      @if (old('agama'))
                      <option>{{old('agama')}}</option>
                      @endif
                      <option>Islam</option>
                      <option>Kristen</option>
                      <option>Katholik</option>
                      <option>Hindu</option>
                      <option>Budha</option>
                      <option>Konghucu</option>
                      <option>Lain-lain</option>
                    </select>
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label for="alamat">Alamat <code>*)</code></label>
                    <input type="text" name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{old('alamat')}}" required>
                    @error('alamat')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group col-md-6 col-6">
                    <label for="hp">No. Hp <code>*) Contoh 6285xxxxxxx ,</code></label>
                    <input type="text" name="hp" id="hp" class="form-control @error('hp') is-invalid @enderror" value="{{old('hp')}}" >
                    @error('hp')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>


                  <div class="form-group col-md-6 col-6">
                    <label>Tahun Pelajaran <code>*)</code></label>
                    <select class="form-control form-control-lg" required name="tapel_nama">
                          @if (old('tapel_nama'))
                          <option>{{old('tapel_nama')}}</option>
                          @endif
                      @foreach ($tapel as $t)
                          <option>{{ $t->nama }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label>Kelas <code>*)</code></label>
                    <select class="form-control form-control-lg" required name="kelas_nama">
                          @if (old('kelas_nama'))
                          <option>{{old('kelas_nama')}}</option>
                          @endif
                      @foreach ($kelas as $k)
                          <option>{{ $k->nama }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group col-md-12 col-12">
                    <label for="email">Email <code>*)</code></label>
                    <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" onblur="duplicateEmail(this)"  required>
                    @error('email')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label for="password">Password <code>*)</code></label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label for="password2">Konfirmasi Password <code>*)</code></label>
                    <input type="password" name="password2" id="password2" class="form-control @error('password2') is-invalid @enderror"  required>
                    @error('password2')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                </div>

            </div>
            <div class="card-footer text-right">
              <button class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>




      </div>
    </div>
  </div>
@endsection
