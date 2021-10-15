@extends('layouts.layoutadmin1')

@section('title')
{{ ucfirst($pages) }}
@endsection
@section('halaman')
{{ $pages }}
@endsection

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

{{-- DATALAPORAN --}}
@php
$sumpemasukan = DB::table('pemasukan')
  ->sum('nominal');

$countpemasukan = DB::table('pemasukan')
  ->count();


$sumpengeluaran = DB::table('pengeluaran')
  ->sum('nominal');

$countpengeluaran = DB::table('pengeluaran')
  ->count();


$sumtagihansiswa = DB::table('pembayarandetail')
  ->sum('nominal');

$counttagihansiswa = DB::table('pembayarandetail')
  ->count();

$sisasaldo=$sumpemasukan+$sumtagihansiswa-$sumpengeluaran;
@endphp
{{-- DATALAPORAN-END --}}

{{-- DATATABLE --}}
@section('headtable')
  <th width="5%" class="text-center">#</th>
  <th>Judul </th>
  <th>Jumlah Transaksi </th>
  <th>Jumlah </th>
  <th width="100px" class="text-center"></th>
@endsection

@section('bodytable')
<tr>
  <td class="text-center">1</td>
  <td>Pemasukan</td>
  <td>{{ $countpemasukan }}</td>
  <td>@currency($sumpemasukan)</td>
  <td class="text-center">
    <a  href="{{ route('pemasukan') }}"  class="btn btn-icon icon-left btn-info btn-sm"><i class="fas fa-search"></i>Detail</a>
  </td>
</tr>
<tr>
  <td class="text-center">2</td>
  <td>Pembayaran Siswa</td>
  <td>{{ $counttagihansiswa }}</td>
  <td>@currency($sumtagihansiswa)</td>
  <td class="text-center">

    @if(Auth::user()->tipeuser==='admin')
    <a href="{{ route('siswa') }}"  class="btn btn-icon icon-left btn-info btn-sm"><i class="fas fa-search"></i>Detail</a>
    @else
    <a href="/kepsek/tagihansiswa"  class="btn btn-icon icon-left btn-info btn-sm"><i class="fas fa-search"></i>Detail</a>
    @endif
  </td>
</tr>
<tr>
  <td class="text-center">3</td>
  <td>Pengeluaran</td>
  <td>{{ $countpengeluaran }}</td>
  <td>@currency($sumpengeluaran)</td>
  <td class="text-center">
    <a href="{{ route('pengeluaran') }}"  class="btn btn-icon icon-left btn-info btn-sm"><i class="fas fa-search"></i>Detail</a>
  </td>
</tr>
<tr>
  <td class="text-center">4</td>
  <td>Sisa Saldo</td>
  <td></td>
  <td>@currency($sisasaldo)</td>
  <td class="text-center">
    <a href="{{ route('laporan.cetak') }}" class="btn btn-icon icon-left btn-info btn-sm"><i class="fas fa-print"></i>Cetak</a>

  </td>
</tr>


@endsection

@section('foottable')
  {{ $datas->links() }}
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
    <div class="row mt-sm-4">

      <div class="col-12 col-md-12 col-lg-12">
        <div class="card profile-widget">
                <div class="row">
                    <div class="col-3">
                        <div class="form-group ml-3 mt-3">
                @php
                    if(old('bln')!=null){
                        $bln=old('bln');
                    }else{
                        $bln=date('Y-m');
                    }

                @endphp
                <input type="month" name="bln" id="bln"
                    class="form-control " placeholder=""
                    value="{{$bln}}" required>


            </div>
            </div>

            <div class="col-3 mt-3">
                <a href="{{url('/admin/laporan/cetak/'.$bln)}}" type="submit" value="cetak" id="blncetak"
                 class="btn btn-primary btn-md"><span class="pcoded-micon"> <i class="fas fa-print"></i>   Cetak PDF </span></a>
            </div>
            </div>


            <script>
                $(document).ready(function(){

                //  fetch_customer_data();
                cari = $("input[name=cari]").val();
                bln = $("input[name=bln]").val();

                 function fetch_customer_data(query = '')
                 {
                  $.ajax({
                   url:"{{ route('laporan.cetak') }}",
                   method:'GET',
                   data:{
                            "_token": "{{ csrf_token() }}",
                            bln: bln,
                        },
                   dataType:'json',
                   success:function(data)
                   {
                       $('#tampilpemasukan').html(data.outputpemasukan);
                       $('#tampilpengeluaran').html(data.outputpengeluaran);
                       $('#tampildenda').html(data.outputdenda);
                       $('#tampilsaldo').html(data.outputsaldo);
                   }
                  })
                 }


                 $(document).on('change', '#bln', function(){
                bln = $("input[name=bln]").val();
                $("#blncetak").prop('href','{{url('/admin/laporan/cetak/')}}/'+bln);
                  var query = $(this).val();
                  fetch_customer_data(query);
                 });
                //  $("button#clear").click(function(){

                //     //  alert('');
                //      $("input[name=cari]").val('');
                //  });
                });
                </script>

            <div class="card-body mt-0">
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
