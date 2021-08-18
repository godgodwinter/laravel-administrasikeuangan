@extends('layouts.layoutadmin1')

@section('title','Tagihan Ku')
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

@php
$tipeuser=(Auth::user()->tipeuser);
@endphp

{{-- DATATABLE --}}
@section('headtable')
<th width="5%" class="text-center">#</th>
<th>Nama Tagihan</th>
<th>Nominal Tagihan</th>
<th>Terbayar</th>
<th>Kurang</th>
{{-- <th>Tipe</th> --}}
<th>Tahun dan Semester</th>
<th width="150px" class="text-center">%</th>
@endsection

@section('bodytable')
@foreach ($datas as $data)
@php

$sumdetailbayar = DB::table('pembayarandetail')
      ->where('pembayaran_id', '=', $data->id)
      ->sum('nominal');

if($data->tipe==='perbulan'){

  $kurang=($data->nominaltagihan*6)-$sumdetailbayar;
  $persen=number_format((($sumdetailbayar/($data->nominaltagihan*6))*100),2);
}else{

$kurang=$data->nominaltagihan-$sumdetailbayar;
$persen=number_format((($sumdetailbayar/$data->nominaltagihan)*100),2);
}

if($persen=='100'){

  $warna='success';
}else{

  $warna='secondary';
}
@endphp
  <tr>
    <td class="text-center">
        <button class="btn btn-icon btn-{{ $warna }}" data-toggle="modal" data-target="#modalbayar{{ $data->id }}" ><i class="far fa-money-bill-alt"></i></button>
    </td>
    <td>{{ $data->namatagihan }} </td>
    <td>@currency($data->nominaltagihan) @if($data->tipe==='perbulan')
        / Perbulan = @currency($data->nominaltagihan*6)  (6 Bulan)
    @endif </td>
    <td>@currency($sumdetailbayar) </td>
    <td>@currency($kurang) </td>
    {{-- <td>{{ $data->tipe }} </td> --}}
    @if($data->tipe==='sekali')
    <td> - </td>
    @else

    <td>{{ $data->tapel_nama }} - {{ $data->semester }}</td>
        
    @endif

    <td class="text-center">{{ $persen }} %</td>
  
   
  </tr>
  @if($data->tipe==='perbulan')

  @for ($i=0;$i<6;$i++)

  <tr>
    <td colspan="2">
        @php

        $no=$i;
            $blndsni=date('Y-m', strtotime('+'.$no.' month', strtotime( $data->bln ))); 

       $datetime = DateTime::createFromFormat('Y-m-d', $blndsni.'-01');

       $maxbln=$datetime->format('Y-m');
            // echo $blndsni;

$sumdetailbayarbln = DB::table('pembayarandetail')
      ->where('pembayaran_id', '=', $data->id)
      ->where('bln', '=', $datetime->format('Y-m'))
      ->sum('nominal');

$kurangbln=$data->nominaltagihan-$sumdetailbayarbln;
        @endphp
        {{ $datetime->format('M Y') }}
    </td>
    <td>@currency($data->nominaltagihan)</td>
    <td>@currency($sumdetailbayarbln)</td>
    <td>@currency($kurangbln)</td>
    {{-- <td>{{ $data->tipe }}</td> --}}
    <td>{{ $data->tapel_nama }} - {{ $data->semester }}</td>
    <td class="text-center">-</td>
    <td class="text-center">-</td>
</tr>
                    
  @endfor
  @endif
@endforeach
@endsection

@section('foottable') 

@endsection

{{-- DATATABLE-END --}}

@section('container')

@php
        
$ambilsiswa = DB::table('siswa')
  ->where('nis', '=', Auth::user()->nomerinduk)
  ->get();
  foreach ($ambilsiswa as $siswa) {
    # code...
  }

    
$ambilsiswausers = DB::table('users')
  ->where('nomerinduk', '=', Auth::user()->nomerinduk)
  ->get();
  foreach ($ambilsiswausers as $du) {
    # code...
  }
      @endphp


<section class="section">
  <div class="section-body">
    <h2 class="section-title">Hi, {{ Auth::user()->name }}!</h2>
    <p class="section-lead">
      Berikut adalah informasi tentang pembayaran tagihan anda. Hubungi admin jika data anda belum muncul. Kemungkinan Belum di Sinkronisasi!
    </p>


    <div class="col-12 col-md-12 col-lg-12">

      <div class="card profile-widget">
          <div class="profile-widget-header">
              <img alt="image" src="{{ asset("assets/") }}/img/products/product-3-50.png" class="rounded-circle profile-widget-picture">
              <div class="profile-widget-items">
              <div class="profile-widget-item">
                  <div class="profile-widget-item-label">Tabel </div>
                  <div class="profile-widget-item-value">Pembayaran</div>
                  {{-- <h4>Simple Table</h4> --}}
              </div>
              </div>
          </div>
      {{-- @yield('datatable') --}}
      {{-- {{ dd($datas) }} --}}      
      
          <div class="card-body -mt-5">
              <div class="table-responsive">
                  <table class="table table-bordered table-md">
                  <tr>
                      @yield('headtable')
                  </tr>
                      @yield('bodytable')
                  
                  </table>
              </div>
              <div class="card-footer text-right">
                      @yield('foottable')
              </div>
          </div>   
      
      </div>
        
     </div> 




      <div class="col-12 col-md-12 col-lg-7">
        <div class="card">
          <div class="card">
            <form action="/admin/siswa/{{ $siswa->id}}" method="post">
                @method('put')
                @csrf
              <div class="card-header">
                  <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> EDIT  Profile</span>
              </div>
              <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-6 col-6">
                      <label for="nis">NIS <code>*)</code></label>
                      <input type="number" name="nis" id="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ $siswa->nis }}" required readonly>
                      @error('nis')<div class="invalid-feedback"> {{$message}}</div>
                      @enderror
                    </div>
                   
                    <div class="form-group col-md-6 col-6">
                      <label for="nama">Nama <code>*)</code></label>
                      <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ $siswa->nama }}" required>
                      @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                      @enderror
                    </div>
                   
                    <div class="form-group col-md-6 col-6">
                      <label for="tempatlahir">Tempat Lahir <code>*)</code></label>
                      <input type="text" name="tempatlahir" id="tempatlahir" class="form-control @error('tempatlahir') is-invalid @enderror" value="{{ $siswa->tempatlahir }}" required>
                      @error('tempatlahir')<div class="invalid-feedback"> {{$message}}</div>
                      @enderror
                    </div>
  
                    <div class="form-group col-md-6 col-6">
                      <label>Tanggal Lahir</label>
                      <input type="date" class="form-control" name="tgllahir" @error('tgllahir') is-invalid @enderror" value="{{ $siswa->tgllahir }}" >
                      @error('tgllahir')<div class="invalid-feedback"> {{$message}}</div>
                      @enderror
                    </div>
  
                    <div class="form-group col-md-6 col-6">
                      <label>Agama <code>*)</code></label>
                      <select class="form-control form-control-lg" required name="agama"> 
                        @if ($siswa->agama)
                        <option>{{ $siswa->agama }}</option>                        
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
                      <input type="text" name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{ $siswa->alamat }}" required>
                      @error('alamat')<div class="invalid-feedback"> {{$message}}</div>
                      @enderror
                    </div>
  
  
                    <div class="form-group col-md-6 col-6">
                      <label>Tahun Pelajaran <code>*)</code></label>
                      <select class="form-control form-control-lg" required name="tapel_nama" readonly>  
                            @if ($siswa->tapel_nama)
                            <option>{{ $siswa->tapel_nama }}</option>                        
                            @endif
                   
                      </select>
                    </div>
  
                    <div class="form-group col-md-6 col-6">
                      <label>Kelas <code>*)</code></label>
                      <select class="form-control form-control-lg" required name="kelas_nama" readonly>
                            @if ($siswa->kelas_nama)
                            <option>{{ $siswa->kelas_nama }}</option>                        
                            @endif
                     
                      </select>
                    </div>
                    
                    <div class="form-group col-md-12 col-12">
                      <label for="email">Email <code>*)</code></label>
                      <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ $du->email }}" onblur="duplicateEmail(this)"  required readonly>
                      @error('email')<div class="invalid-feedback"> {{$message}}</div>
                      @enderror
                    </div>
  
                    <div class="form-group col-md-6 col-6">
                      <label for="password">Password <code>*) Kosongkan Password jika tidak ingin mengubah</code></label>
                      <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" value="">
                      @error('password')<div class="invalid-feedback"> {{$message}}</div>
                      @enderror
                    </div>
  
                    <div class="form-group col-md-6 col-6">
                      <label for="password2">Konfirmasi Password <code>*)</code></label>
                      <input type="password" name="password2" id="password2" class="form-control @error('password2') is-invalid @enderror" value="">
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
</section>

  
@endsection



@section('container-modals')

@foreach ($datas as $data)
@php
  
$sumdetailbayar = DB::table('pembayarandetail')
      ->where('pembayaran_id', '=', $data->id)
      ->sum('nominal');

if($data->tipe==='perbulan'){

  $kurang=($data->nominaltagihan*6)-$sumdetailbayar;
  $persen=number_format((($sumdetailbayar/($data->nominaltagihan*6))*100),2);
}else{

$kurang=$data->nominaltagihan-$sumdetailbayar;
$persen=number_format((($sumdetailbayar/$data->nominaltagihan)*100),2);
}

if($persen=='100'){

  $warna='success';
}else{

  $warna='secondary';
}
@endphp
<div class="modal fade" tabindex="-1" role="dialog" id="modalbayar{{ $data->id }}">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pembayaran "{{ $data->namatagihan }}"</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form action="/admin/datasiswa/{{ $data->id }}/bayar" method="post">
          @csrf
        <div class="form-group">

          @if (old('nominal'))
          @php                    
            $nominal=old('nominal');
          @endphp
      @else
          @php
          $nominal=0;
          @endphp                    
      @endif

      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text">Sisa Tagihan :
          </div>
        </div>  
         <input type="text" class="form-control-plaintext" readonly="" value="@currency($kurang)" >
      </div>

        </div>

    
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        {{-- <button type="submit" class="btn btn-primary">Bayar</button> --}}
        </form>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-bordered table-md">
            <tr>
              <th width="5%" class="text-center">Pembayaran ke-</th>
              <th>Nominal</th>
              <th class="text-center">Tanggal Bayar</th>
            </tr>
            @php
            $detailbayar = DB::table('pembayarandetail')
              ->where('pembayaran_id', '=', $data->id)
              ->get();
            @endphp
            @foreach ($detailbayar as $db)
         
            <tr>
              <td  class="text-center">{{ ($loop->index)+1 }}</td>
              <td class="text-left">
                @currency($db->nominal)</td>

                @php

            $blndsni2=date('d M Y', strtotime('+7 month', strtotime( $db->tglbayar ))); 

            // $datetime = DateTime::createFromFormat('Y-m-d', $blndsni);

            // $maxbln=$datetime->format('Y-m');

                @endphp
              <td class="text-center">{{ $blndsni2 }}</td>
           
              </tr>

            @endforeach


          </table>
      </div>

  </div>
</div>
</div>
</div>
</div>
@endforeach

@endsection