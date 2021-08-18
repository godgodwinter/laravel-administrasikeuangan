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
  <th width="150px" class="text-center">Aksi</th>
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
    <td class="text-center">
        <x-button-edit link="/admin/datasiswa/{{$data->id}}/edit" />
        <x-button-delete link="/admin/datasiswa/{{$data->id}}/delete" /> </td>
   
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

  
  
       <div class="col-12 col-md-12 col-lg-7" id="add">
        <div class="card">
            <form action="/admin/datasiswa/{{ $siswa->id }}" method="post">
                @csrf
            <div class="card-header">
                <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> TAMBAH TAGIHAN</span>
            </div>
            <div class="card-body">
                <div class="row">
                 
                  <div class="form-group col-md-6 col-6">
                    <label for="namatagihan">Nama Tagihan<code>*)</code></label>
                    <input type="text" name="namatagihan" id="namatagihan" class="form-control @error('namatagihan') is-invalid @enderror" value="{{old('namatagihan')}}" required>
                    @error('namatagihan')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>
                 

                  <div class="form-group col-md-6 col-6">
                    <label>Tipe Bayar <code>*)</code></label>
                    <select class="form-control form-control-lg" required name="tipe">  
                          @if (old('tipe'))
                          <option>{{old('tipe')}}</option>                        
                          @endif
                    
                          <option value="perbulan">Perbulan</option>
                          <option value="persemester">Persemester</option>
                          <option value="sekali">Sekali</option>
                    </select>
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label>Tahun Pelajaran <code>*)</code></label>
                    <select class="form-control form-control-lg" required name="tapel_nama">  
                          @if (old('tapel_nama'))
                          <option>{{old('tapel_nama')}}</option> 
                          @else
                          <option>{{$tapelaktif}}</option>  

                          @endif
                          
                      @foreach ($tapel as $t)
                          <option>{{ $t->nama }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label>Semester <code>*)</code></label>
                    <select class="form-control form-control-lg" required name="semester">  
                          @if (old('semester'))
                          <option>{{old('semester')}}</option>   
                          @else
                          
                          <option>{{$semesteraktif}}</option>                       
                          @endif

                          <option>Semester 1</option>   
                          <option>Semester 2</option>   
                    </select>
                  </div>


                  @if (old('nominaltagihan'))
                      @php                    
                        $nominaltagihan=old('nominaltagihan');
                      @endphp
                  @else
                      @php
                      $nominaltagihan=0;
                      @endphp                    
                  @endif
                  <div class="form-group col-md-6 col-6">
                    <label for="nominaltagihan">Nominal <code>*)</code> </label>
                    <input type="text" name="labelrupiah" min="0" id="labelrupiah" class="form-control-plaintext" readonly="" value="Rp 0,00" >
                    <input type="number" name="nominaltagihan" min="0" id="rupiah" class="form-control @error('nominaltagihan') is-invalid @enderror" value="{{ $nominaltagihan }}" required>
                    @error('nominaltagihan')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <script type="text/javascript">
                    
                    var rupiah = document.getElementById('rupiah');
                    var labelrupiah = document.getElementById('labelrupiah');
                    rupiah.addEventListener('keyup', function(e){
                      // tambahkan 'Rp.' pada saat form di ketik
                      // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                      // rupiah.value = formatRupiah(this.value, 'Rp. ');
                      labelrupiah.value = formatRupiah(this.value, 'Rp. ');
                    });
                
                    /* Fungsi formatRupiah */
                    function formatRupiah(angka, prefix){
                      var number_string = angka.replace(/[^,\d]/g, '').toString(),
                      split   		= number_string.split(','),
                      sisa     		= split[0].length % 3,
                      rupiah     		= split[0].substr(0, sisa),
                      ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
                
                      // tambahkan titik jika yang di input sudah menjadi angka ribuan
                      if(ribuan){
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                      }
                
                      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                      return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
                    }
                  </script>
                
                 
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
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text">Nominal Bayar:
          </div>
        </div>  
         <input type="text" name="labelrupiah" min="0" id="labelrupiah{{ $data->id }}" class="form-control-plaintext" readonly="" value="@currency($nominal)" >
      </div>
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">
                <i class="far fa-money-bill-alt""></i>
              </div>
            </div>
            <input type="number" class="form-control  @error('nominal') is-invalid @enderror" name="nominal" max="{{ $kurang }}" id="rupiah{{ $data->id }}" value="{{ $nominal }}"  required>

              @error('nominal')<div class="invalid-feedback"> {{$message}}</div>
              @enderror
          </div>

        </div>


      <script type="text/javascript">
        
        var rupiah{{ $data->id }} = document.getElementById('rupiah{{ $data->id }}');
        var labelrupiah{{ $data->id }} = document.getElementById('labelrupiah{{ $data->id }}');
        rupiah{{ $data->id }}.addEventListener('keyup', function(e){
          // tambahkan 'Rp.' pada saat form di ketik
          // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
          // rupiah.value = formatRupiah(this.value, 'Rp. ');
          labelrupiah{{ $data->id }}.value = formatRupiah(this.value, 'Rp. ');
        });
    
        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix){
          var number_string = angka.replace(/[^,\d]/g, '').toString(),
          split   		= number_string.split(','),
          sisa     		= split[0].length % 3,
          rupiah     		= split[0].substr(0, sisa),
          ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
    
          // tambahkan titik jika yang di input sudah menjadi angka ribuan
          if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
          }
    
          rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
          return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
      </script>

@if($data->tipe==='perbulan')
  <label>Pilih Bulan<code>*)</code></label>
  <input placeholder="Pilih Bulan" type="month" id="date" class="form-control form-control-sm mb-3" name="bln" min="{{ $data->bln }}" max={{ $maxbln }} value="{{ $data->bln }}" required>
@endif 
    
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Bayar</button>
        </form>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-bordered table-md">
            <tr>
              <th width="5%" class="text-center">Pembayaran ke-</th>
              <th>Nominal</th>
              <th class="text-center">Tgl Bayar</th>
              <th width="5%" class="text-center">Aksi</th>
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
              <td class="text-center"> 
                <form action="/admin/datasiswa/bayar/{{$db->id}}/hapus  " method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button class="btn btn-icon btn-danger"
                        onclick="return  confirm('Anda yakin menghapus data ini? Y/N')"><span
                            class="pcoded-micon"> <i class="fas fa-trash"></i></span></button>
              </form>
                </td>
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