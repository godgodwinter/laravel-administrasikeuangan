@extends('layouts.layoutadmin1')

@section('title','Detail Siswa')
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
  <th>Tipe</th>
  <th>Tahun dan Semester</th>
  <th width="150px" class="text-center">Aksi</th>
@endsection

@section('bodytable')
@foreach ($datas as $data)
  <tr>
    <td>{{ ((($loop->index)+1)) }}</td>
    <td>{{ $data->siswa_nis }} - {{ $data->siswa_nama }}</td>
   
  </tr>
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
                    <div class="profile-widget-item-value">@yield('title')</div>
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
            <form action="/admin/{{ $pages }}" method="post">
                @csrf
            <div class="card-header">
                <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> TAMBAH TAGIHAN</span>
            </div>
            <div class="card-body">
                <div class="row">
                 
                  <div class="form-group col-md-6 col-6">
                    <label for="nama">Nama Tagihan<code>*)</code></label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{old('nama')}}" required>
                    @error('nama')<div class="invalid-feedback"> {{$message}}</div>
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



                  @if (old('defaultvalue'))
                      @php                    
                        $defaultvalue=old('defaultvalue');
                      @endphp
                  @else
                      @php
                      $defaultvalue=0;
                      @endphp                    
                  @endif
                  <div class="form-group col-md-6 col-6">
                    <label for="defaultvalue">Nominal <code>*)</code> </label>
                    <input type="text" name="labelrupiah" min="0" id="labelrupiah" class="form-control-plaintext" readonly="" value="Rp 0,00" >
                    <input type="number" name="defaultvalue" min="0" id="rupiah" class="form-control @error('defaultvalue') is-invalid @enderror" value="{{ $defaultvalue }}" required>
                    @error('defaultvalue')<div class="invalid-feedback"> {{$message}}</div>
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
