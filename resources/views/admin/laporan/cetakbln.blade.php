@php
    if(empty($pages)){
        $pages='kosong';
    }

    $ambilsettings = DB::table('settings')
      ->where('id', '=', '1')
      ->get();
      foreach ($ambilsettings as $settings) {
      }

      $inputan=$bln;
        $bulanindo='Januari';
        $str=explode("-",$inputan);
                if($str[1]=='01'){
                    $bulanindo='Januari';
                }elseif($str[1]=='02'){
                    $bulanindo='Februari';
                }elseif($str[1]=='03'){
                    $bulanindo='Maret';
                }elseif($str[1]=='04'){
                    $bulanindo='April';
                }elseif($str[1]=='05'){
                    $bulanindo='Mei';
                }elseif($str[1]=='06'){
                    $bulanindo='Juni';
                }elseif($str[1]=='07'){
                    $bulanindo='Juli';
                }elseif($str[1]=='08'){
                    $bulanindo='Agustus';
                }elseif($str[1]=='09'){
                    $bulanindo='September';
                }elseif($str[1]=='10'){
                    $bulanindo='Oktober';
                }elseif($str[1]=='11'){
                    $bulanindo='November';
                }else{
                    $bulanindo='Desember';
                }

                $inputan2=date('Y-m');
        $bulanindo2='Januari';
        $str=explode("-",$inputan2);
                if($str[1]=='01'){
                    $bulanindo2='Januari';
                }elseif($str[1]=='02'){
                    $bulanindo2='Februari';
                }elseif($str[1]=='03'){
                    $bulanindo2='Maret';
                }elseif($str[1]=='04'){
                    $bulanindo2='April';
                }elseif($str[1]=='05'){
                    $bulanindo2='Mei';
                }elseif($str[1]=='06'){
                    $bulanindo2='Juni';
                }elseif($str[1]=='07'){
                    $bulanindo2='Juli';
                }elseif($str[1]=='08'){
                    $bulanindo2='Agustus';
                }elseif($str[1]=='09'){
                    $bulanindo2='September';
                }elseif($str[1]=='10'){
                    $bulanindo2='Oktober';
                }elseif($str[1]=='11'){
                    $bulanindo2='November';
                }else{
                    $bulanindo2='Desember';
                }


@endphp



{{-- DATALAPORAN --}}
@php
$sumpemasukan = DB::table('pemasukan')->whereNotIn('kategori_nama', ['Dana Bos'])->whereMonth('tglbayar',$month)->whereYear('tglbayar',$year)
  ->sum('nominal');

$countpemasukan = DB::table('pemasukan')->whereNotIn('kategori_nama', ['Dana Bos'])->whereMonth('tglbayar',$month)->whereYear('tglbayar',$year)
  ->count();

$sumpemasukanbos = DB::table('pemasukan')->where('kategori_nama','Dana Bos')->whereMonth('tglbayar',$month)->whereYear('tglbayar',$year)
  ->sum('nominal');

$countpemasukanbos = DB::table('pemasukan')->where('kategori_nama','Dana Bos')->whereMonth('tglbayar',$month)->whereYear('tglbayar',$year)
  ->count();


$sumpengeluaran = DB::table('pengeluaran')->whereNotIn('kategori_nama', ['Dana Bos'])->whereMonth('tglbayar',$month)->whereYear('tglbayar',$year)
  ->sum('nominal');

$countpengeluaran = DB::table('pengeluaran')->whereNotIn('kategori_nama', ['Dana Bos'])->whereMonth('tglbayar',$month)->whereYear('tglbayar',$year)
  ->count();

  $sumpengeluaranbos = DB::table('pengeluaran')->where('kategori_nama','Dana Bos')->whereMonth('tglbayar',$month)->whereYear('tglbayar',$year)
  ->sum('nominal');

$countpengeluaranbos = DB::table('pengeluaran')->where('kategori_nama','Dana Bos')->whereMonth('tglbayar',$month)->whereYear('tglbayar',$year)
  ->count();

// $countpengeluaran = DB::table('pengeluaran')
//   ->count();


// $sumpengeluaran = DB::table('pengeluaran')
//   ->sum('nominal');

$sumtagihansiswa = DB::table('pembayarandetail')->whereMonth('tglbayar',$month)->whereYear('tglbayar',$year)
  ->sum('nominal');

$counttagihansiswa = DB::table('pembayarandetail')->whereMonth('tglbayar',$month)->whereYear('tglbayar',$year)
  ->count();

// $totalpemasukan=$sumpemasukan+$sumtagihansiswa+$sumpemasukanbos;
$totalpemasukan=$sumtagihansiswa+$sumpemasukanbos;
$totalpengeluaran=$sumpengeluaran+$sumpengeluaranbos;
$sisasaldo=$totalpemasukan-$totalpengeluaran;


$ambilkepsek = DB::table('users')
->where('tipeuser','kepsek')
  ->get();
  foreach ($ambilkepsek as $kepsek) {
      # code...
  }
@endphp
{{-- DATALAPORAN-END --}}


@section('title')
Laporan Pemasukan dan Pengeluaran di {{ $settings->sekolahnama }}
@endsection

@section('kepsek')
Kepala Sekolah
@endsection

@section('alamat')
{{ $settings->sekolahalamat }}
@endsection

@section('telp')
{{ $settings->sekolahtelp }}
@endsection

@section('namasekolah')
{{ $settings->sekolahnama }}
@endsection

@section('logo','logoyayasan.png')

{{-- DATATABLE --}}


@section('bodytable')
<tr>
    <td align="center">1</td>
    <td align="left"><b>Pemasukan dari Dana BOS</b></td>
    <td align="center"><b>{{ $countpemasukanbos }} Transaksi</b></td>
    <td align="center"><b>@currency($sumpemasukanbos)</b></td>

  </tr>
  @foreach ($databos as $db)

  <tr>
      <td align="center"></td>
      <td align="left">{{ $db->nama }}</td>
      <td align="center">{{ $db->kategori_nama }}</td>
      <td align="center">@currency($db->nominal)</td>

    </tr>

    @endforeach

{{--
<tr>
  <td align="center">2</td>
  <td align="left"><b>Pemasukan Selain Dana BOS</b></td>
  <td align="center"><b>{{ $countpemasukan }} Transaksi</b></td>
  <td align="center"><b>@currency($sumpemasukan)</b></td>

</tr>
@foreach ($datapemasukan as $dpem)

<tr>
    <td align="center"></td>
    <td align="left">{{ $dpem->nama }}</td>
    <td align="center">{{ $dpem->kategori_nama }}</td>
    <td align="center">@currency($dpem->nominal)</td>

  </tr>

  @endforeach --}}



  <tr>
    <td align="center">2</td>
    <td align="left"><b>Pembayaran Siswa</b></td>
    <td align="center"><b>{{ $counttagihansiswa }} Transaksi</b></td>
    <td align="center"><b>@currency($sumtagihansiswa)</b></td>

  </tr>

  <tr>
    <td align="left" colspan="3"><b>Total Pemasukan</b></td>
    <td align="center"><b>@currency($totalpemasukan)</b></td>

  </tr>



@endsection
{{-- DATATABLE-END --}}


{{-- DATATABLEdua --}}


@section('bodytable2')


<tr>
  <td align="center">1</td>
  <td align="left"><b>Pengeluaran Dana BOS</b></td>
  <td align="center"><b>{{ $countpengeluaranbos }} Transaksi</b></td>
  <td align="center"><b>@currency($sumpengeluaranbos)</b></td>

</tr>
@foreach ($pengeluaranbos as $pb)

<tr>
    <td align="center"></td>
    <td align="left">{{ $pb->nama }}</td>
    <td align="center">{{ $pb->kategori_nama }}</td>
    <td align="center">@currency($pb->nominal)</td>

  </tr>

  @endforeach
  <tr>
    <td align="center">2</td>
    <td align="left"><b>Pengeluaran Siswa</b></td>
    <td align="center"><b>{{ $countpengeluaran }} Transaksi</b></td>
    <td align="center"><b>@currency($sumpengeluaran)</b></td>

  </tr>
  @foreach ($datapengeluaran as $dpeng)

  <tr>
      <td align="center"></td>
      <td align="left">{{ $dpeng->nama }}</td>
      <td align="center">{{ $dpeng->kategori_nama }}</td>
      <td align="center">@currency($dpeng->nominal)</td>

    </tr>

    @endforeach
  <tr>
    <td align="left" colspan="3"><b>Total Pengeluaran</b></td>
    <td align="center"><b>@currency($totalpengeluaran)</b></td>

  </tr>






@endsection
{{-- DATATABLEdua-END --}}


{{-- DATATABLETIGA --}}


@section('bodytable3')


<tr>
  <td align="center">1</td>
  <td align="left"><b>Pemasukan dari Dana BOS</b></td>
  <td align="center"><b>{{ $countpemasukanbos }} Transaksi</b></td>
  <td align="center"><b>@currency($sumpemasukanbos)</b></td>

</tr>

{{-- <tr>
  <td align="center">2</td>
  <td align="left"><b>Pemasukan Selain Dana BOS</b></td>
  <td align="center"><b>{{ $countpemasukan }} Transaksi</b></td>
  <td align="center"><b>@currency($sumpemasukan)</b></td>

</tr> --}}

<tr>
  <td align="center">2</td>
  <td align="left"><b>Pembayaran Siswa</b></td>
  <td align="center"><b>{{ $counttagihansiswa }} Transaksi</b></td>
  <td align="center"><b>@currency($sumtagihansiswa)</b></td>

</tr>

<tr>
  <td align="center">3</td>
  <td align="left"><b>Pengeluaran dari Dana BOS</b></td>
  <td align="center"><b>{{ $countpengeluaranbos }} Transaksi</b></td>
  <td align="center"><b>@currency($sumpengeluaranbos)</b></td>

</tr>
<tr>
  <td align="center">4</td>
  <td align="left"><b>Pengeluaran Siswa</b></td>
  <td align="center"><b>{{ $countpengeluaran }} Transaksi</b></td>
  <td align="center"><b>@currency($sumpengeluaran)</b></td>

</tr>

  <tr>
    <td align="left" colspan="3"><b>Total Saldo</b></td>
    <td align="center"><b>@currency($sisasaldo)</b></td>

  </tr>






@endsection
{{-- DATATABLETIGA-END --}}


<html>
    <head>
        <title>@yield('title')</title>
    </head>
    <body>
        <style type="text/css">
        table {
            border-spacing: 0;
            margin: 2px;
          }
        th {
                padding: 5px;
            }
        td {
                padding: 5px;
            }
            table tr td,
            table tr th{
                font-size: 12px;
                font-family: Georgia, 'Times New Roman', Times, serif;
            }
            td{
                height:10px;
            }
            body {
                font-size: 12px;
                font-family:Georgia, 'Times New Roman', Times, serif;
                }
            h1 h2 h3 h4 h5{
                line-height: 1.2;
            }
            .spa{
              letter-spacing:3px;
            }
          hr.style2 {
            border-top: 3px double #8c8b8b;
          }
        </style>
        <table width="100%" border="0">
            <tr>
            <td width="13%" align="right"><img src="assets/upload/@yield('logo')" width="140" height="140"></td>
            <td width="80%" align="center"><p><b><font size="28px">YAYASAN PENDIDIKAN ISLAM <br> " SMPI LUKMAN HAKIM "</font><br>
              <font size="18px"> KENDAL PAYAK - KECAMATAN PAKISAJI - KABUPATEN MALANG</font>
            </b>
            <br>
            <br> <font size="14px">Sekretariat : Jl. Kendalpayak No.98 Pakisaji - Malang. TELP. 085746911467</font>
                                        </p>

                                        </td>
            <td widht="7%"></td>
            </tr>
            <tr>
                <td colspan="3"><hr  class="style2">
                </td>
            </tr>
            </table>
            {{-- <center><h2>@yield('title')</h2></center> --}}

                <h3>Laporan Pemasukan pada bulan {{$bulanindo}} {{$year}}</h3>
                <table width="100%" border="1">
                @yield('bodytable')
                </table>

                <h3>Laporan Pengeluaran pada bulan {{$bulanindo}} {{$year}}</h3>
                <table width="100%" border="1">
                @yield('bodytable2')
                </table>

                <h3>Sisa saldo pada bulan {{$bulanindo}} {{$year}}</h3>
                <table width="100%" border="1">
                @yield('bodytable3')
                </table>

                <br>

    <table width="100%" border="0">
        <tr>
            <th width="3%"></th>
            <th width="30%" align="center">
                <br>
               <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <br><br><br><br><br><br><br><br>
                {{-- <hr style="width:70%; border-top:2px dotted; border-style: none none dotted;  "> --}}

            </th>

            <th width="34%"></th>

            <th width="30%" align="center">{{date('d')}}, {{$bulanindo2}}  @php
               echo  date('Y');
            @endphp

                <br>Yang Membuat Pernyataan,<br>
                <br><br>
                <br><br>
                <br><br>
                <br><br>
                {{-- <img src="data:image/png;base64, {!! $qrcode !!}"> --}}
                {{-- <hr style="width:80%; border-top:2px dotted; border-style: none none dotted;  "> --}}
                <b>@yield('kepsek')</b>
            </th>
            <th width="3%"></th>

        </tr>
    </table>
    </body>
    </html>
