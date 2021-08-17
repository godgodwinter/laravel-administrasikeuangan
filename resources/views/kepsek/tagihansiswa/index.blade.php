@extends('layouts.layoutadmin1')

@section('title','Siswa')
@section('halaman','tagihansiswa')

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
        <a href="/kepsek/datasiswa/{{$data->id}}" class="btn btn-info btn-sm"><i class="fas fa-search-plus"></i></a>
      
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
            <form action="{{ route('kepsek.tagihansiswa.cari') }}" method="GET">
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

    </div>
  </div>
@endsection
