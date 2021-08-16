@extends('layouts.layoutadmin1')

@section('title')
Pembayaran Siswa , NIS : {{ $pembayaran->siswa_nis }} - Nama :  {{ $pembayaran->siswa_nama }}
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
  <th>Nominal</th>
  <th>Terbayar</th>
  <th>Tipe</th>
  <th>Tahun dan Semester</th>
  <th width="150px" class="text-center">Aksi</th>
@endsection

@section('bodytable')
@foreach ($datas as $data)
@php
    $warna='success';
@endphp
  <tr>
    <td class="text-center">
        <button class="btn btn-icon btn-{{ $warna }}" data-toggle="modal" data-target="#modalbayar{{ $data->id }}" ><i class="far fa-money-bill-alt"></i></button>
    </td>
    <td>{{ $data->namatagihan }} </td>
    <td>@currency($data->nominaltagihan) </td>
    <td>@currency(0) </td>
    <td>{{ $data->tipe }} </td>
    @if($data->tipe==='sekali')
    <td> - </td>
    @else

    <td>{{ $data->tapel_nama }} - {{ $data->semester }}</td>
        
    @endif
    <td class="text-center">
        <x-button-edit link="/admin/datasiswa/{{$data->id}}/edit" />
        <x-button-delete link="/admin/datasiswa/{{$data->id}}/delete" /> </td>
   
  </tr>
  @if($data->tipe==='perbulan')
      <tr>
          <td>bulan</td>
      </tr>
  @endif
@endforeach
@endsection

@section('foottable') 
@endsection

{{-- DATATABLE-END --}}

@section('container')

  <div class="section-body">
    
              

    <div class="row mt-sm-0"> 


      <div class="col-12 col-md-12 col-lg-7" id="add">
        <div class="card">
          <form action="/admin/datasiswa/{{ $pembayaran->id}}/edit" method="post">
              @method('put')
              @csrf
            <div class="card-header">
                <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> EDIT</span>
            </div>
            <div class="card-body">
                <div class="row">
                 
                  <div class="form-group col-md-6 col-6">
                    <label for="namatagihan">Nama Tagihan<code>*)</code></label>
                    <input type="text" name="namatagihan" id="namatagihan" class="form-control @error('namatagihan') is-invalid @enderror" value="{{$pembayaran->namatagihan}}" required>
                    @error('namatagihan')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>
                 

                  <div class="form-group col-md-6 col-6">
                    <label>Tipe Bayar <code>*)</code></label>
                    <select class="form-control form-control-lg" required name="tipe">  
                         
                    
                          <option value="{{$pembayaran->tipe}}">{{ucfirst($pembayaran->tipe)}}</option>
                          <option value="perbulan">Perbulan</option>
                          <option value="persemester">Persemester</option>
                          <option value="sekali">Sekali</option>
                    </select>
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label>Tahun Pelajaran <code>*)</code></label>
                    <select class="form-control form-control-lg" required name="tapel_nama">  
                         

                          <option>{{$pembayaran->tapel_nama}}</option>  
                          
                      @foreach ($tapel as $t)
                          <option>{{ $t->nama }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label>Semester <code>*)</code></label>
                    <select class="form-control form-control-lg" required name="semester">  
                        
                      <option>{{$pembayaran->semester}}</option> 

                          <option>Semester 1</option>   
                          <option>Semester 2</option>   
                    </select>
                  </div>


                  @if ($pembayaran->nominaltagihan)
                      @php                    
                        $nominaltagihan=$pembayaran->nominaltagihan;
                      @endphp
                  @else
                      @php
                      $nominaltagihan=0;
                      @endphp                    
                  @endif
                  <div class="form-group col-md-6 col-6">
                    <label for="nominaltagihan">Nominal <code>*)</code> </label>
                    <input type="text" name="labelrupiah" min="0" id="labelrupiah" class="form-control-plaintext" readonly="" value="@currency($nominaltagihan)" >
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
