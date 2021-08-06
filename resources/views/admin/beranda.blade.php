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
    <h2 class="section-title">Hi, {{ Auth::user()->name }}!</h2>
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
                <div class="profile-widget-item-label">Lunas</div>
                <div class="profile-widget-item-value">{{ $lunas }} </div>
              </div>
              <div class="profile-widget-item">
                <div class="profile-widget-item-label">Belum Lunas</div>
                <div class="profile-widget-item-value"> {{ $belumlunas }} </div>
              </div>
            </div>
          </div>

          <div class="card-footer text-center">
            <div class="font-weight-bold mb-2">Lihat Selengkapnya</div>
            <a href="#" class="btn btn-info mr-1">
              <i class="fas fa-angle-double-right"></i>
            </a>
            
          </div>
       
      
        </div>


        <div class="card profile-widget mt-5">
            <div class="profile-widget-header">
              <img alt="image" src="../assets/img/products/product-4-50.png" class="rounded-circle profile-widget-picture">
              <div class="profile-widget-items">
             
                <div class="profile-widget-item">
                  <div class="profile-widget-item-label">Pemasukan</div>
                  <div class="profile-widget-item-value">@currency($ttlpemasukan)</div>
                </div>
                <div class="profile-widget-item">
                  <div class="profile-widget-item-label">Pengeluaran</div>
                  <div class="profile-widget-item-value">@currency($ttlpengeluaran)</div>
                </div>
                <div class="profile-widget-item">
                  <div class="profile-widget-item-label">Saldo</div>
                  <div class="profile-widget-item-value">@currency($saldo)</div>
                </div>
              </div>
            </div>
            <div class="card-footer text-center">
                <div class="font-weight-bold mb-2">Lihat Selengkapnya</div>
                <a href="#" class="btn btn-info mr-1">
                  <i class="fas fa-angle-double-right"></i>
                </a>
                
              </div>
        
          </div>
      </div>
      <div class="col-12 col-md-12 col-lg-6">
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
                    <label for="paginationjml">Pagination <code>*)</code></label>
                    <input type="number" name="paginationjml" id="paginationjml" class="form-control @error('paginationjml') is-invalid @enderror" value="{{$paginationjml}}" required>
                    @error('paginationjml')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

            <div class="form-group col-md-5 col-5  mt-3">
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
            </div>
            <div class="card-footer text-right">
              <button class="btn btn-primary">Simpan</button>
            </div>
          
          
            </form>
          </div>
             
              
              
          </div>

       
      
        </div>
        

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
                  
                  <a  href="{{ route('tagihanatur') }}" type="button" class="btn btn-danger"><i class="fas fa-fire"></i> Tagihan Atur </a>
                  <a  href="{{ route('tagihansiswa') }}" type="button" class="btn btn-danger"><i class="fas fa-graduation-cap"></i> Tagihan Siswa </a>
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


    </div>
  </div>
@endsection
