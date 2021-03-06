@extends('layouts.layoutadmin1')

@section('title','Beranda')
@section('halaman','Index')

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

@if (session('status'))

  <div class="alert alert-{{ $tipe }} alert-has-icon alert-dismissible show fade">
    <div class="alert-icon"><i class="{{ $icon }}"></i></div>
                      <div class="alert-body">
                        <div class="alert-title">{{ Str::ucfirst($tipe) }}</div>
                        <button class="close" data-dismiss="alert">
                          <span>&times;</span>
                        </button>
                        {{ session('status') }}
                      </div>
                    </div>
@endif
@endsection

@php
$tipeuser=(Auth::user()->tipeuser);
@endphp

@if(($tipeuser)==='kepsek')
  @php
      $hakakses='Kepala Sekolah';
  @endphp
@elseif(($tipeuser)==='admin')
@php
    $hakakses='Administrator';
@endphp
@elseif(($tipeuser)==='siswa')
@php
    $hakakses='Siswa';
@endphp
@endif



{{-- DATALAPORAN --}}
@php
$sumpemasukan = DB::table('pemasukan')->whereNotIn('kategori_nama', ['Dana Bos'])
  ->sum('nominal');

//   SELECT sum('nominal') from pemasukan where kateri_nama!=Dana Bos;

$countpemasukan = DB::table('pemasukan')->whereNotIn('kategori_nama', ['Dana Bos'])
  ->count();

$sumpemasukanbos = DB::table('pemasukan')->where('kategori_nama','Dana Bos')
  ->sum('nominal');

$countpemasukanbos = DB::table('pemasukan')->where('kategori_nama','Dana Bos')
  ->count();


$sumpengeluaran = DB::table('pengeluaran')->whereNotIn('kategori_nama', ['Dana Bos'])
  ->sum('nominal');

$countpengeluaran = DB::table('pengeluaran')->whereNotIn('kategori_nama', ['Dana Bos'])
  ->count();

$sumpengeluaranbos = DB::table('pengeluaran')->where('kategori_nama','Dana Bos')
  ->sum('nominal');

$countpengeluaranbos = DB::table('pengeluaran')->where('kategori_nama','Dana Bos')
  ->count();


$sumtagihansiswa = DB::table('pembayarandetail')
  ->sum('nominal');

$counttagihansiswa = DB::table('pembayarandetail')
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
@section('container')


{{-- <div class="section-header">
    <h1>Typography</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="#">Bootstrap Components</a></div>
      <div class="breadcrumb-item">Typography</div>
    </div>
  </div> --}}


  <div class="section-body">
    <h2 class="section-title">Hi, {{ Auth::user()->name }} dari {{ $sekolahnama }} ! Anda Login sebagai {{ $hakakses }}</h2>
    <p class="section-lead">
     Berikut beberapa Informasi tetang data dan menu di Sistem Ini.
    </p>

    <div class="row mt-sm-4">
      <div class="col-12 col-md-12 col-lg-6">
        <div class="card profile-widget">
          <div class="profile-widget-header">
            <img alt="image" src="../assets/img/products/product-3-50.png" class="rounded-circle profile-widget-picture">
            <div class="profile-widget-items">
              <div class="profile-widget-item">
                <div class="profile-widget-item-label">Kelas</div>
                <div class="profile-widget-item-value"> {{ $kelas }} Kelas</div>
              </div>
              <div class="profile-widget-item">
                <div class="profile-widget-item-label">Siswa</div>
                <div class="profile-widget-item-value">{{ $siswa }} Siswa</div>
              </div>
              <div class="profile-widget-item">
                <div class="profile-widget-item-label">Pembayaran Lunas</div>
                <div class="profile-widget-item-value">{{ $lunas }} </div>
              </div>
              <div class="profile-widget-item">
                <div class="profile-widget-item-label">Pembayaran Belum Lunas</div>
                <div class="profile-widget-item-value"> {{ $belumlunas }} </div>
              </div>
            </div>
          </div>

          {{-- <div class="card-footer text-center">
            <div class="font-weight-bold mb-2">Lihat Selengkapnya</div>
            <a href="#" class="btn btn-info mr-1">
              <i class="fas fa-angle-double-right"></i>
            </a>

          </div> --}}


        </div>



        @if(Auth::user()->tipeuser!=='siswa')
        <div class="card profile-widget mt-5">
            <div class="profile-widget-header">
              <img alt="image" src="../assets/img/products/product-4-50.png" class="rounded-circle profile-widget-picture">
              <div class="profile-widget-items">

                <div class="profile-widget-item">
                  <div class="profile-widget-item-label">Pemasukan Dana BOS</div>
                  <div class="profile-widget-item-value">@currency($sumpemasukanbos)</div>
                </div>
                {{-- <div class="profile-widget-item">
                  <div class="profile-widget-item-label">Pemasukan Selain Dana BOS</div>
                  <div class="profile-widget-item-value">@currency($sumpemasukan)</div>
                </div> --}}
                <div class="profile-widget-item">
                  <div class="profile-widget-item-label">Pembayaran Siswa</div>
                  <div class="profile-widget-item-value">@currency($sumtagihansiswa)</div>
                </div>
              </div>

              <div class="profile-widget-items mt-4">


                <div class="profile-widget-item">
                  <div class="profile-widget-item-label">Pengeluaran dari Dana BOS</div>
                  <div class="profile-widget-item-value">@currency($sumpengeluaranbos)</div>
                </div>
                <div class="profile-widget-item">
                  <div class="profile-widget-item-label">Pengeluaran Selain Dana BOS</div>
                  <div class="profile-widget-item-value">@currency($sumpengeluaran)</div>
                </div>
                <div class="profile-widget-item">
                  <div class="profile-widget-item-label">Saldo</div>
                  <div class="profile-widget-item-value">@currency($sisasaldo)</div>
                </div>
              </div>
            </div>
            {{-- <div class="card-footer text-center">
                <div class="font-weight-bold mb-2">Lihat Selengkapnya</div>
                <a href="#" class="btn btn-info mr-1">
                  <i class="fas fa-angle-double-right"></i>
                </a>

              </div> --}}

          </div>


        @endif


          @if($tipeuser==='admin')

      <div class="card profile-widget mt-5">
        <div class="profile-widget-header">
          <img alt="image" src="../assets/img/products/product-3-50.png" class="rounded-circle profile-widget-picture">
          <div class="profile-widget-items">
            <h3 class="ml-5 mt-4">Menu Mastering</h3>
          </div>


            <div class="card-body">
              <div class="btn-group mb-3 btn-group-lg" role="group" aria-label="Basic example">
                <a  href="{{ route('kategori') }}" type="button" class="btn btn-warning"><i class="fab fa-korvue"></i> Kategori</a>
              </div>
              <div class="btn-group mb-3 btn-group-lg" role="group" aria-label="Basic example">
                <a  href="{{ route('tapel') }}" type="button" class="btn btn-primary"><i class="fas fa-calendar-alt"></i> Tahun Pelajaran</a>
                <a  href="{{ route('kelas') }}" type="button" class="btn btn-primary"><i class="fas fa-school"></i> Kelas</a>
              </div>
                <div class="btn-group mb-3 btn-group-lg" role="group" aria-label="Basic example">
                <a  href="{{ route('siswa') }}" type="button" class="btn btn-info"><i class="fas fa-user-graduate"></i> Siswa</a>
                <a  href="{{ route('pegawai') }}" type="button" class="btn btn-info"><i class="fas fa-building"></i> Pegawai</a>
              </div>
              <div class="profile-widget-items">
                <h3 class="ml-5 mt-4">Menu Transaksi / Proses</h3>
              </div>
              <div class="btn-group btn-group-lg" role="group" aria-label="Basic example">
                <a  href="{{ route('pemasukan') }}" type="button" class="btn btn-light"><i class="fas fa-hand-holding-usd"></i> Pemasukan</a>
                <a  href="{{ route('pengeluaran') }}" type="button" class="btn btn-light"><i class="fas fa-file-invoice-dollar"></i> Pengeluaran</a>
              </div>
              <div class="clearfix"></div>
              <div class="btn-group btn-group-lg mt-3" role="group" aria-label="Basic example">

                {{-- <a  href="{{ route('tagihanatur') }}" type="button" class="btn btn-danger"><i class="fas fa-fire"></i> Tagihan Atur </a>
                <a  href="{{ route('tagihansiswa') }}" type="button" class="btn btn-danger"><i class="fas fa-graduation-cap"></i> Tagihan Siswa </a> --}}
              </div>

              <div class="profile-widget-items">
                <h3 class="ml-5 mt-4">Menu Reporting</h3>
              </div>
                <div class="btn-group btn-group-lg mt-3" role="group" aria-label="Basic example">
                  <a  href="{{ route('laporan') }}" type="button" class="btn btn-success"> <i class="fab fa-resolving"></i> Laporan </a>
                </div>
              </div>

        </div>



      </div>

      @endif




      </div>
      <div class="col-12 col-md-12 col-lg-6">

        @if($tipeuser!=='siswa')

        <div class="card profile-widget">
          <div class="profile-widget-header">
            <img alt="image" src="../assets/img/products/product-3-50.png" class="rounded-circle profile-widget-picture">
            <div class="profile-widget-items">
              <h3 class="ml-5 mt-4">Pengaturan Web</h3>
            </div>

            <div class="card">
              <form action="/admin/settings/1" method="post">
                  @csrf

                  <div class="row">
                    <div class="form-group col-md-5 col-5 mt-3 ml-5">
                      <label for="aplikasijudul">Nama Aplikasi <code>*)</code></label>
                      <input type="text" name="aplikasijudul" id="aplikasijudul" class="form-control @error('aplikasijudul') is-invalid @enderror" value="{{$aplikasijudul}}" required>
                      @error('aplikasijudul')<div class="invalid-feedback"> {{$message}}</div>
                      @enderror
                    </div>
                    <div class="form-group col-md-5 col-5 mt-3 ml-5">
                      <label for="aplikasijudulsingkat">Nama Aplikasi (Singkat) <code>*) 2/3 Huruf</code></label>
                      <input type="text" name="aplikasijudulsingkat" id="aplikasijudulsingkat" class="form-control @error('aplikasijudulsingkat') is-invalid @enderror" value="{{$aplikasijudulsingkat}}" required>
                      @error('aplikasijudulsingkat')<div class="invalid-feedback"> {{$message}}</div>
                      @enderror
                    </div>
                    <div class="form-group col-md-5 col-5 mt-3 ml-5">
                      <label for="sekolahnama">Nama Sekolah <code>*)</code></label>
                      <input type="text" name="sekolahnama" id="sekolahnama" class="form-control @error('sekolahnama') is-invalid @enderror" value="{{$sekolahnama}}" required>
                      @error('sekolahnama')<div class="invalid-feedback"> {{$message}}</div>
                      @enderror
                    </div>
                    <div class="form-group col-md-5 col-5 mt-3 ml-5">
                      <label for="sekolahalamat">Alamat Sekolah <code>*)</code></label>
                      <input type="text" name="sekolahalamat" id="sekolahalamat" class="form-control @error('sekolahalamat') is-invalid @enderror" value="{{$sekolahalamat}}" required>
                      @error('sekolahalamat')<div class="invalid-feedback"> {{$message}}</div>
                      @enderror
                    </div>
                    <div class="form-group col-md-5 col-5 mt-3 ml-5">
                      <label for="sekolahtelp">Telp Sekolah <code>*)</code></label>
                      <input type="text" name="sekolahtelp" id="sekolahtelp" class="form-control @error('sekolahtelp') is-invalid @enderror" value="{{$sekolahtelp}}" required>
                      @error('sekolahtelp')<div class="invalid-feedback"> {{$message}}</div>
                      @enderror
                    </div>
                  <div class="form-group col-md-5 col-5 mt-3 ml-5">
                    <label for="paginationjml">Pagination <code>*)</code></label>
                    <input type="number" name="paginationjml" id="paginationjml" class="form-control @error('paginationjml') is-invalid @enderror" value="{{$paginationjml}}" required>
                    @error('paginationjml')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>



            <div class="form-group col-md-5 col-5  mt-3 ml-5">
              <label>Tahun Pelajaran Aktif<code>*)</code></label>
              <select class="form-control form-control-lg @error('tapelaktif') is-invalid @enderror" required name="tapelaktif">
                    @if ($tapelaktif)
                    <option>{{$tapelaktif}}</option>
                    @endif
                @foreach ($tapel as $t)
                    <option>{{ $t->nama }}</option>
                @endforeach
              </select>
              @error('tapelaktif')<div class="invalid-feedback"> {{$message}}</div>
              @enderror
            </div>

            <div class="form-group col-md-5 col-5  mt-3 ml-5">
              <label>Semester Aktif<code>*)</code></label>
              <select class="form-control form-control-lg @error('semesteraktif') is-invalid @enderror" required name="semesteraktif">
                    @if ($semesteraktif)
                    <option>{{$semesteraktif}}</option>
                    @endif
                    <option>Semester 1</option>
                    <option>Semester 2</option>

              </select>
              @error('semesteraktif')<div class="invalid-feedback"> {{$message}}</div>
              @enderror
            </div>

            <div class="form-group col-md-5 col-5  mt-3 ml-5">
              <label>Bulan Dimulai Semester 1<code>*)</code></label>
              <input placeholder="Pilih Bulan" type="month" id="date" class="form-control form-control-sm" name="semester1bln"  value="{{ $semester1bln }}" required>
              @error('tapelaktif')<div class="invalid-feedback"> {{$message}}</div>
              @enderror
            </div>

            <div class="form-group col-md-5 col-5  mt-3 ml-5">
              <label>Bulan Dimulai Semester 2<code>*)</code></label>
              <input placeholder="Pilih Bulan" type="month" id="date" class="form-control form-control-sm" name="semester2bln"  value="{{ $semester2bln }}" required>
              @error('tapelaktif')<div class="invalid-feedback"> {{$message}}</div>
              @enderror
            </div>

            </div>
            <div class="card-footer text-right">
              <button class="btn btn-primary">Simpan</button>
            </div>


            </form>
          </div>



          </div>



        </div>
        @endif

        @if($tipeuser==='siswa')
        <div class="card profile-widget mt-5">
          <div class="profile-widget-header">
            <img alt="image" src="../assets/img/products/product-3-50.png" class="rounded-circle profile-widget-picture">
            <div class="profile-widget-items">
              <h3 class="ml-5 mt-4">Menu Siswa</h3>
            </div>


              <div class="card-body">
                <div class="btn-group mb-3 btn-group-lg" role="group" aria-label="Basic example">
                  <a  href="{{ url('user/profile') }}" type="button" class="btn btn-warning"><i class="fab fa-korvue"></i> Profile</a>
                </div>
                <div class="btn-group mb-3 btn-group-lg" role="group" aria-label="Basic example">
                  <a  href="{{ route('siswa.tagihansiswa') }}" type="button" class="btn btn-primary"><i class="fas fa-calendar-alt"></i> Tagihanku</a>
                </div>

          </div>



        </div>

        @endif




    </div>

    <div class="col-12 col-md-12 col-lg-6">

  </div>


  </div>
@endsection
