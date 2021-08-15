@extends('layouts.layoutadmin1')

@section('title','Jenis Tagihan')
@section('halaman','pembayaran')

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
  <th>Tipe Bayar</th>
  <th>Nominal</th>
  <th width="100px" class="text-center">Aksi</th>
@endsection

@section('bodytable')
@foreach ($datas as $data)
  <tr>
    <td>{{ (($loop->index)+1) }}</td>
    <td>{{ $data->nama }}</td>
    <td>{{ Str::ucfirst($data->tipe) }}</td>
    <td>@currency($data->defaultvalue)</td>
    <td class="text-center">
        <x-button-edit link="/admin/{{ $pages }}/{{$data->id}}" />
        <x-button-delete link="/admin/{{ $pages }}/{{$data->id}}" />
    </td>
  </tr>
@endforeach
@endsection

@section('foottable') 
 
@endsection

{{-- DATATABLE-END --}}

@section('container')


         
  <div class="section-body">
    <p class="section-lead">
     Menu untuk mengatur Nominal Tagihan siswa.
    </p>

    <div class="row mt-sm-4">
      <div class="col-12 col-md-12 col-lg-5">
        <x-layout-table pages="{{ $pages }}" pagination="1"/>
       </div> 
      <div class="col-12 col-md-12 col-lg-7">
        <div class="card">
          <form action="/admin/{{  $pages }}/{{ $pembayaran->id}}" method="post">
              @method('put')
              @csrf
            <div class="card-header">
                <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> EDIT</span>
            </div>
            <div class="card-body">
                <div class="row">

                  <div class="form-group col-md-6 col-6">
                    <label for="nama">Nama <code>*)</code></label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{$pembayaran->nama}}" required>
                    @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label>Tipe Bayar <code>*)</code></label>
                    <select class="form-control form-control-lg" required name="tipe">  

                      <option>{{$pembayaran->tipe}}</option> 
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
                      $defaultvalue=$pembayaran->defaultvalue;
                      @endphp                    
                  @endif
                  <div class="form-group col-md-6 col-6">
                    <label for="defaultvalue">Nominal <code>*)</code> </label>
                    <input type="text" name="labelrupiah" min="0" id="labelrupiah" class="form-control-plaintext" readonly="" value="@currency($defaultvalue)" >
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

            {{-- <div class="card-body">
                <div class="section-title mt-0">Catatan : </div>
                <blockquote>
                  Jika Tahun Pelajaran dan Kelas sudah ada maka akan edit data tersebut.
                </blockquote>
              </div> --}}
          </form>
        </div>


        

      </div>
    </div>
  </div>
@endsection
