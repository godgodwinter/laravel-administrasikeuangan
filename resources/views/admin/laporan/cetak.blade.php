@php
    if(empty($pages)){
        $pages='kosong';
    }

    $ambilsettings = DB::table('settings')
      ->where('id', '=', '1')
      ->get();
      foreach ($ambilsettings as $settings) {
      }
@endphp


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


$sumtagihansiswa = DB::table('tagihansiswadetail')
  ->sum('nominal');

$counttagihansiswa = DB::table('tagihansiswadetail')
  ->count();

$sisasaldo=$sumpemasukan+$sumtagihansiswa-$sumpengeluaran;


$ambilkepsek = DB::table('users')
->where('tipeuser','kepsek')
  ->get();
  foreach ($ambilkepsek as $kepsek) {
      # code...
  }
@endphp
{{-- DATALAPORAN-END --}}
<html>
    <head>
        <title>Laporan Tahun Pelajaran</title>
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
        </style>
        <table width="100%" border="0">
            <tr>
            <td width="13%" align="right"><img src="assets/upload/logotutwuri.png" width="110" height="110"></td>
            <td width="80%" align="center"><p><b><font size="28px">{{ $settings->sekolahnama }}</font><br>
            </b>
                                         <br>{{ $settings->sekolahalamat }}<BR>
                                            Telp: {{ $settings->sekolahtelp }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;http://google.com
                                        </p>
    
                                        </td>
            <td widht="7%"></td>
            </tr>
            <tr>
                <td colspan="3"><hr style="border:2px;">
                </td>
            </tr>
            </table>
            <center><h1>Laporan</h1></center>
    
      <table width="100%" border="1">
    
    
                  {{-- {{dd($pernyataans)}} --}}
    
                    <tr>
                        <th width="5%" class="text-center">#</th>
                        <th>Judul </th>
                        <th>Jumlah Transaksi </th>
                        <th>Jumlah </th>
                    </tr>
                    
    
    
<tr>
    <td align="center">1</td>
    <td align="left">Pemasukan</td>
    <td align="center">{{ $countpemasukan }}</td>
    <td align="center">@currency($sumpemasukan)</td>
    
  </tr>
  <tr>
    <td  align="center">2</td>
    <td>Pembayaran Siswa</td>
    <td align="center">{{ $counttagihansiswa }}</td>
    <td align="center">@currency($sumtagihansiswa)</td>
  
  </tr>
  <tr>
    <td  align="center">3</td>
    <td>Pengeluaran</td>
    <td align="center">{{ $countpengeluaran }}</td>
    <td align="center">@currency($sumpengeluaran)</td>
   
  </tr>
  <tr>
    <td  align="center">4</td>
    <td>Sisa Saldo</td>
    <td></td>
    <td align="center">@currency($sisasaldo)</td>
    
  </tr>
                  </tfoot>
                </table>
                <br>
              
    <br><br><br><br><br>
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
    
            <th width="30%" align="center">.........,..........................,  @php
               echo  date('Y');
            @endphp
    
                <br>Yang Membuat Pernyataan,<br>
                <br><br>
                <br><br>
                <br><br>
                <br><br>
                {{-- <img src="data:image/png;base64, {!! $qrcode !!}"> --}}
                {{-- <hr style="width:80%; border-top:2px dotted; border-style: none none dotted;  "> --}}
                <b>{{ $kepsek->name }}</b>
            </th>
            <th width="3%"></th>
    
        </tr>
    </table>
    </body>
    </html>
    