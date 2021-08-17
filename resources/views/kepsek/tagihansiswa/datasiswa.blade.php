@extends('layouts.layoutadmin1')

@section('title')
Pembayaran Siswa , NIS : {{ $siswa->nis }} - Nama :  {{ $siswa->nama }}
@endsection
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

  <div class="section-body">
    
              

    <div class="row mt-sm-0"> 
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

  
    </div>
  </div>
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
        </form>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-bordered table-md">
            <tr>
              <th width="5%" class="text-center">Pembayaran ke-</th>
              <th>Nominal</th>
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